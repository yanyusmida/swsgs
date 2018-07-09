<?php

/**
 * Description of user
 *
 * @author abby.kim
 */
class Payments extends CI_Model {

	private $_registration;
	private $_payed_registration;
	private $_payment_logs;
	private $_email_logs;
	private $_workshops;

	public function __construct() {
		parent::__construct();
		
		$this->_registration = $this->db->dbprefix("registration");
		$this->_payed_registration = $this->db->dbprefix("payed_registration");
		$this->_payment_logs = $this->db->dbprefix("payment_logs");
		$this->_email_logs = $this->db->dbprefix("email_logs");
		$this->_workshops = $this->db->dbprefix("workshops");
	}
	
	public function	record_payment($reg_id, $token){
		$data = array();
		
		$data['reg_id'] = $reg_id;
		$data['token'] = $token;
		$payment_data = $this->get_payment_data_by_token($token);
		$data['response'] = json_encode($payment_data);
		$data['created_date'] = date('Y-m-d H:i:s');
		
		$result = $this->db->insert($this->_payment_logs, $data);
		
		if(!$result){
			log_message('error', 'record payment insert: -->' . json_encode($data));
		}
		
		if(!empty($payment_data) && $payment_data['status'] == 'SUCCESS'){
			$record_count = $this->db->where('reg_id', $data['reg_id'])->get($this->_payed_registration)->num_rows();			
			if($record_count == 0){
				$this->insert_payed_registration($reg_id);
			}
			return 'yes';
		}else{
			return 'no';
		}
	}
	
	public function	record_payment_ipn($payment_data){
		$data = array();
		
		$data['reg_id'] = $payment_data['custom'];		
		$data['response'] = json_encode($payment_data);
		$data['created_date'] = date('Y-m-d H:i:s');
		
		$result = $this->db->insert($this->_payment_logs, $data);
		
		if($result){			
			$record_count = $this->db->where('reg_id', $data['reg_id'])->get($this->_payed_registration)->num_rows();			
			if($record_count == 0){
				$this->insert_payed_registration($data['reg_id']);
			}
		}else{
			log_message('error', 'record payment ipn: -->' . json_encode($data));
		}
	}
		
	public function get_registration($reg_id){
		return $this->db->where('id', $reg_id)->get($this->_registration)->row_array();
	}
	
	public function	insert_payed_registration($reg_id){
		$created_date = date('Y-m-d H:i:s');
		$registration_data = $this->get_registration($reg_id); 
		$data = array(
			'reg_id' => $reg_id,
			'reg_type' => 'paypal',
			'reg_email' => $registration_data['email'],
			'reg_workshop_id' => $registration_data['workshop_id'],
			'reg_class_id' => $registration_data['class_id'],
			'created_date' => $created_date
		);
		
		$result = $this->db->insert($this->_payed_registration, $data);
		if(!$result){
			log_message('error', 'insert payed registration: -->' . json_encode($data));
		}
		
		$update_data = array('payed' => 'yes');
		$result2 = $this->db->update($this->_registration, $update_data, array('id' => $reg_id));
		
		if(!$result2){
			log_message('error', 'insert payed registration ('.$reg_id.'): -->' . json_encode($update_data));
		}
		
		$this->send_email($registration_data);
	}
	
	public function	get_payment_data_by_token($token){
		$pp_hostname = PP_HOST;
		$auth_token = PP_TOKEN;		
		$tx_token = $token;
		
		$req = "cmd=_notify-synch&tx=".$tx_token."&at=".$auth_token;

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'cURL/PHP');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_SSLVERSION, 6);

		$res = curl_exec($ch);
		

		if($res === false){
			log_message('error', 'PDT curl error: -->' . curl_error($ch));
			curl_close($ch);
			return array();
		}else{
			curl_error($ch);
			log_message('error', 'PDT : ' . $res);
			
			$lines = explode("\n", $res);
			$keyarray = array();
			
			if (strcmp ($lines[0], "SUCCESS") == 0) {
				$keyarray['status'] = "SUCCESS";
				for ($i=1; $i<count($lines);$i++){
					$parts = explode("=", $lines[$i]);
			    if (count($parts)==2) {
			    	$keyarray[$parts[0]] = urldecode($parts[1]);
			    }
				}
			}else{
				$keyarray['status'] = "FAIL";
			}
			return $keyarray;
		}
	}
		
	public function get_workshop_for_email($workshop_id){
		$select = 'title, mail_title,  mail_str';
		return $this->db->select($select)->where('id', $workshop_id)->get($this->_workshops)->row_array();
	}
	
	public function	send_email($user_detail){
		$event_detail = $this->get_workshop_for_email($user_detail['workshop_id']);
		
		if(isset($user_detail['workshop_id']) && isset($event_detail['mail_title'])){	
			$email_subject = $event_detail['mail_title'];
			
			$email_body = $event_detail['mail_str'];
			
			$email_body = str_replace("[::workshop_title::]", $event_detail['title'], $email_body);
			$email_body = str_replace("[::user_first_name::]", $user_detail['first_name'], $email_body);
			$email_body = str_replace("[::user_family_name::]", $user_detail['family_name'], $email_body);
			$email_body = str_replace("[::user_nric::]", $user_detail['nric'], $email_body);
			$email_body = str_replace("[::user_contact_number::]", $user_detail['contact_number'], $email_body);			
			$email_body = str_replace("[::user_workshop_day::]", $user_detail['workshop_day'], $email_body);
			$email_body = str_replace("[::user_workshop_time::]", $user_detail['workshop_time'], $email_body);
			
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);
			$this->email->from("sulwhasooSG@iris365.com","Sulwhasoo Singapore");
			$this->email->to($user_detail['email']);
			$this->email->subject($email_subject);
			$this->email->message($email_body);
			
			if ($this->email->send()) {
				$this->email_log($user_detail['id'], $user_detail['email'], $email_body);
			}
		}
	}
	
	function email_log($reg_id, $email, $str){		
		$sent_ata = array( 'reg_id' => $reg_id, 'email' => $email, 'send_type' => 'workshop', 'email_msg' => $str);
		$result = $this->db->insert("email_logs", $sent_ata);
		if(!$result){
			log_message('error', 'send email log: '. $reg_id);
		}
	}
}

?>
