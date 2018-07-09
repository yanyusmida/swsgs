<?php

/**
 * Description of user
 *
 * @author abby.kim
 */
class Samplings extends CI_Model {

	private $_samplings;
	private $_sample_users;
	private $_preorder;
	private $_preorder_users;
	private $sms_logs;
	

	public function __construct() {
		parent::__construct();
		//数据库名
		$this->_samplings = $this->db->dbprefix("samplings");
		$this->_sample_users = $this->db->dbprefix("sample_users");
		$this->_preorder = $this->db->dbprefix("preorder");
		$this->_preorder_users = $this->db->dbprefix("preorder_users");
		$this->sms_logs = $this->db->dbprefix("sms_logs");
	}
	
	//日期是否过期
	function is_closed($sampling_id) {
		$row = $this->get_sampling_selection($sampling_id, 'end_date');
		if(!isset($row['end_date'])){
			log_message('error', 'is_closed return null - sampling');
			return true;
		}else if(date('Y-m-d H:i:s') > $row['end_date']){
			return true;
		}else{
			return false;
		}	
	}

	//_preorder表里的日期是否过期
	function is_closed_preorder($sampling_id) {
		$row = $this->get_preorder_selection($sampling_id, 'end_date');
		if(!isset($row['end_date'])){
			log_message('error', 'is_closed return null - sampling');
			return true;
		}else if(date('Y-m-d H:i:s') > $row['end_date']){
			return true;
		}else{
			return false;
		}	
	}
	
	//sampling
	function get_end_msg($sampling_id) {
		$row = $this->get_sampling_selection($sampling_id, 'end_msg');
		if(isset($row['end_msg'])){
			return $row['end_msg'];
		}else{
			log_message('error', 'get_end_msg return null - sampling');
			return 'Sorry! The samplings are all filled.';
		}	
	}

	// preorder
	function get_end_msg_preorder($preorder_id) {
		$row = $this->get_preorder_selection($preorder_id, 'end_msg');
		if(isset($row['end_msg'])){
			return $row['end_msg'];
		}else{
			log_message('error', 'get_end_msg_preorder return null - preorder');
			return 'Sorry! The preorder are all filled.';
		}	
	}

	//获取preorder数据表里的end_date信息
	public function get_preorder_selection($sampling_id, $select){
		return $this->db->select($select)->where('id', $sampling_id)->get($this->_preorder)->row_array();
	}
	
	//注册是否超过限制
	function is_over($sampling_id){
		$reg_count = $this->db->where('sampling_id', $sampling_id)->get($this->_sample_users)->num_rows();
						 
		$row = $this->get_sampling_selection($sampling_id, 'register_limit');
		if(!isset($row['register_limit'])){
			log_message('error', 'is_over return null - sampling');
			return true;
		}else if(intval($row['register_limit']) > (intval($reg_count))){
			return false;
		}else{
			return true;
		}
	}

	//_preorder表里用户注册是否超过限制
	function is_over_preorder($preorder_id){
		// return true;
		$reg_count = $this->db->where('preorder_id', $preorder_id)->get($this->sms_logs)->num_rows();
		// return true;
		$row = $this->get_preorder_selection($preorder_id, 'register_limit');
		if(!isset($row['register_limit'])){
			log_message('error', 'is_over_preorder return null - preorder');
			return true;
		}else if(intval($row['register_limit']) > (intval($reg_count))){
			return false;
		}else{
			return true;
		}
	}

	//_preorder表
	function get_over_msg_preorder($preorder_id) {
		$row = $this->get_preorder_selection($preorder_id, 'limit_msg');
		if(isset($row['limit_msg'])){
			return $row['limit_msg'];
		}else{
			log_message('error', 'get_over_msg_preorder return null');
			return 'Sorry! The preorder are all filled.';
		}	
	}
	
	function get_over_msg($sampling_id) {
		$row = $this->get_sampling_selection($sampling_id, 'limit_msg');
		if(isset($row['limit_msg'])){
			return $row['limit_msg'];
		}else{
			log_message('error', 'get_over_msg return null');
			return 'Sorry! The samplings are all filled.';
		}	
	}
	
	public function get_sampling_selection($sampling_id, $select){
		return $this->db->select($select)->where('id', $sampling_id)->get($this->_samplings)->row_array();
	}

	
	
	public function get_sampling($sampling_id = 0){
		if($sampling_id > 0){
			return $this->db->where('id', $sampling_id)->get($this->_samplings)->row_array();
		}else{
			$query = "SELECT * FROM {$this->_samplings} WHERE status = 'active' order by id desc limit 0, 1";
			return $this->db->query($query, array())->row_array();
		}
	}

	public function get_preorder($sampling_id = 0){
		if($sampling_id > 0){
			return $this->db->where('id', $sampling_id)->get($this->_preorder)->row_array();
		}else{
			$query = "SELECT * FROM {$this->_preorder} WHERE status = 'active' order by id desc limit 0, 1";
			return $this->db->query($query, array())->row_array();
		}
	}
	
	//验证邮箱是否已注册过
	public function check_have_reg_email($email){
		$payed_count = $this->db->where('email',$email)->get($this->_sample_users)->num_rows();
		
		return ($payed_count > 0)? false:true;
	}

	//验证preorder用户表里的邮箱是否已注册过
	public function check_have_reg_email_preorder($email){
		$payed_count = $this->db->where('contact_number',$email)->get($this->sms_logs)->num_rows();
		
		return ($payed_count > 0)? false:true;
	}
	
	public function user_reg_info($email){
		return $this->db->where('email',$email)->get($this->_sample_users)->row_array();
	}
	
	public function insert_reg($user_data) {
		$data = $this->pre_resolve_data($user_data);
		// var_dump($data);exit();
		// 加载邮件类user_agent
		$this->load->library('user_agent');
		//返回完整的用户代理字符串:
		$user_agent = $this->agent->agent_string();
		$mobile_agent = '/(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS|xiaomi|XiaoMi|MiuiBrowser)/';
		$data['device'] = ( preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) ? "MOBILE":"PC";	
		$data['created_date'] = date('Y-m-d H:i:s');	
				
		$result = $this->db->insert($this->_sample_users, $data);
		
		if($result){				
			$reg_info = $this->user_reg_info($data['email']);
			if(isset($reg_info['id'])){
				$uid = $reg_info['id'];
				$sampling_id = $reg_info['sampling_id'];
			
				$row = $this->get_sampling_selection($sampling_id, 'item_code');			
				if(isset($row['item_code'])){
					$item_code = $row['item_code'];
					
					$url = "http://login.irisrewards.com/reward-admin/?c=redemption&m=post_redemption";
					$post_data = array(
						'client_id' => 9,
						'reg_id' => $uid, 
						'first_name' => $data['first_name'], 
						'family_name' => $data['family_name'], 
						'email' => $data['email'],
						'country_id' => 'Singapore', 
						'contact_number' => $data['contact_number'], 
						'nric' => $data['nric'], 
						'item_code' => $item_code,
						'outlet' => $data['outlet'],
						'gender' => 'Unknown'
					);
					$result = $this->CallAPI('POST', $url, $post_data);
					$result = json_decode($result, true);
					
					if($result['error'] == 0){
						$iris_id = $result['data']['id'];
						$qr_code = $result['data']['file_name'];
						$iris_code = $result['data']['code'];
						$this->iris_update($uid, $iris_id, $qr_code, $iris_code);
						$this->send_email($uid);
					}else{
						log_message('error', 'iris -->' . json_encode($result));
					}			
				}
			}
		}
		return $result;
	}
	
	public function iris_update($uid, $iris_id, $qr_code, $iris_code){	
		$update_data = array( 'qr_code' => $qr_code, 'iris_id' => $iris_id, 'iris_code' => $iris_code );
		$update_data['updated_date'] = date('Y-m-d H:i:s');	
		$this->db->update($this->_sample_users, $update_data, array('id' => $uid));
	}
	
	public function user_reg_info_by_id($reg_id){
		return $this->db->where('id',$reg_id)->get($this->_sample_users)->row_array();
	}
		
	public function	send_email($reg_id){
		$user_detail = $this->user_reg_info_by_id($reg_id);
		$event_detail = $this->get_sampling($user_detail['sampling_id']);
		
		if(isset($user_detail['sampling_id']) && isset($event_detail['mail_title'])){	
			$email_subject = $event_detail['mail_title'];
			
			$email_body = $event_detail['mail_str'];
			
			$qrcode = '<img src="'.$user_detail['qr_code'].'">';
			
			$email_body = str_replace("[::user_first_name::]", $user_detail['first_name'], $email_body);
			$email_body = str_replace("[::user_family_name::]", $user_detail['family_name'], $email_body);
			$email_body = str_replace("[::user_nric::]", $user_detail['nric'], $email_body);
			$email_body = str_replace("[::user_contact_number::]", $user_detail['contact_number'], $email_body);			
			$email_body = str_replace("[::user_outlet::]", $user_detail['outlet'], $email_body);
			$email_body = str_replace("[::user_qr_code::]", $qrcode, $email_body);
			$email_body = str_replace("[::user_iris_code::]", $user_detail['iris_code'], $email_body);
			
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
		$sent_ata = array( 'reg_id' => $reg_id, 'email' => $email, 'send_type' => 'sampling', 'email_msg' => $str);
		$result = $this->db->insert("email_logs", $sent_ata);
		if(!$result){
			log_message('error', 'send email log - sampling: '. $reg_id);
		}
	}
	
	function CallAPI($method, $url, $data = false) {
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
	}
	
	/**
	* 去掉data不存在table里的field的key.
	* @param Array $data
	* @param String $prefix 是否加上前缀后匹配
	* @return Array
	*/	
	function pre_resolve_data($data, $prefix='') {
		$user_fields = $this->db->list_fields($this->_sample_users);
		return array_intersect_key($this->serializeUserData($data, $prefix), array_flip($user_fields));
	}

	function serializeUserData(array $userdata, $prefix = null) {
		foreach ($userdata as $userdata_key => $userdata_value) {
			if (is_array($userdata_value)) {
				$userdata_value = implode(",",$userdata_value);
			}
			$data[$prefix . $userdata_key] = $userdata_value;
		}
		return $data;
	}

	// receivers联系号码
	// content短信内容
	function send_message($appid,$appsecret,$receivers,$content) {
		// 1. 初始化
		 $ch = curl_init();
		 $url = 'http://www.smsdome.com/api/http/sendsms.aspx?appid='.$appid.'&appsecret='.$appsecret.'&receivers='.$receivers.'&content='.$content.'&responseformat=JSON';
		 // 2. 设置选项，包括URL
		 curl_setopt($ch,CURLOPT_URL,$url);
		 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		 curl_setopt($ch,CURLOPT_HEADER,0);
		 // 3. 执行并获取HTML文档内容
		 $output = curl_exec($ch);
		 if($output === FALSE ){
		 	// echo "CURL Error:".curl_error($ch);
		 	return FALSE;
		 }
		 // 4. 释放curl句柄
		 curl_close($ch);

	    return $output;
	}

	// 将表格接收的用户数据添加到数据库
	// $data = First Name
			// Family Name
			// Contact No.
			// NRIC (Last 4 digits)
			// Birth Year
			// Email
			// Preferred Outlet for Collection
			// Quantity
	function add_phone($data) {
		// $sent_ata = array( 'reg_id' => $reg_id, 'email' => $email, 'send_type' => 'sampling', 'email_msg' => $str);
		$data['date_happen'] = date("Y-m-d H:i:s",$data['_'] / 1000);
		unset($data['check-tc']);
		unset($data['_']);
		$result = $this->db->insert("sms_logs", $data);
		return $result;
	}


	
}

?>
