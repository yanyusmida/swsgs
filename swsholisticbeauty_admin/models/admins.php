<?php

/**
 * Description of app
 *
 * @author Abby.kim
 */
    
class admins extends CI_Model {	

	public function __construct() {
		parent::__construct();
	}   
	
	public function edit_theme_info($view_type, $theme_info){
		$old_value = $this->get_theme_info($view_type);
		$result = true;
		foreach ($theme_info as $key => $value) {
  		if($value != "" && $value != "NA"){
  			if(isset($old_value[$key])){
  				$update_date = date('Y-m-d H:i:s');
  				$result_now = $this->db->where(array('field_name' => $key))->update('copies', array('value' => $value, 'update_date' => $update_date));
  				if( $old_value[$key] != $value){
	  				$log_info = array('fnc_name' => 'edit_theme_info', 'type' => $view_type, 'what' => $key, 'old_value' => $old_value[$key], 'new_value' => $value);
  					$this->insert_user_log($log_info);
	  			}
		  		if(!$result_now){
		  			$result = false;
		  		}
  			}	  		
  		}
  	} 
  	return $result;
	}
	
	public function get_theme_info($view_type){
  	$query = "SELECT * FROM copies WHERE type_name = ? order by id asc";
		$data = $this->db->query($query, array($view_type))->result_array();
		if (!empty($data)) {
			$result = array();
			foreach ($data as $r) {
			 	$result[$r['field_name']] = $r['value'];
			} 
			return $result;
	  }else{
	  	return array();
	  }  	
	}
		
	public function get_theme_values($view_type){  	
  	$query = "SELECT * FROM copies WHERE type_name = ? order by id asc";
  	$data = $this->db->query($query, array($view_type))->result_array();
		if (!empty($data)) {
			$result = array();
			foreach ($data as $r) {
			 	$result[$r['field_name']] = array('menu_name' => $r['menu_name'], 'value_type' => $r['value_type'], 'value' => $r['value'], 'value_type_list' => $r['value_type_list']);
			} 
			return $result;
	  }else{
	  	return array();
	  }
	}
	
	//获取数据库里对应的数据表列出数据
	public function get_table($type){
		if($type == "class"){
			return "classes";
		}else if($type == "sampling"){
			return "samplings";
		}else if($type == "workshop"){
			return "workshops";
		}else{
			return "preorder";
		}
	}	
	
	public function get_list_tot($type, $filter, $status, $parent_id = 0, $parent_type = ""){
		$addp = ($status != "all")? "WHERE status = '".$status."'":"WHERE status != 'remove'";
    
		if($parent_id != 0 && $parent_type != ""){
			$addp .= " AND ".$parent_type."_id = ".$parent_id." ";
		}
				
    $table = $this->get_table($type);
    
    $query = "SELECT * FROM ".$table." ".$addp;
    	// return $type;
		return $this->db->query($query, array())->num_rows();
  }
			
	public function get_lists($type, $filter, $status, $start, $parent_id = 0, $parent_type = ""){
		$unit = 10;
		$start_idx = ($unit*$start);
		
		$addp = ($status != "all")? "WHERE status = '".$status."'":"WHERE status != 'remove'";
		if($parent_id != 0 && $parent_type != ""){
			$addp .= " AND ".$parent_type."_id = ".$parent_id." ";
		}
				
		$table = $this->get_table($type);
        
    $query = "SELECT * FROM ".$table." ".$addp." order by create_date desc limit ?,?";		
		$list_data = $this->db->query($query, array($start_idx,$unit))->result_array();
		
		if (!count($list_data)) {
		 	return array();
		}else{
			if($type == "workshop"){
				$new_list_data = array();
				foreach ($list_data as $li) {					
					$li['total'] = $this->db->where(array('reg_workshop_id' => $li['id']))->get('payed_registration')->num_rows(); 
					array_push($new_list_data,$li);
				} 
				return $new_list_data;
			}else if($type == "class"){
				$new_list_data = array();
				foreach ($list_data as $li) {					
					$li['total'] = $this->db->where(array('reg_class_id' => $li['id']))->get('payed_registration')->num_rows(); 
					array_push($new_list_data,$li);
				} 
				return $new_list_data;
			}else if($type == "sampling"){
				$new_list_data = array();
				foreach ($list_data as $li) {					
					$li['total'] = $this->db->where(array('sampling_id' => $li['id']))->get('sample_users')->num_rows(); 
					array_push($new_list_data,$li);
				} 
				return $new_list_data;
			}else if($type == "preorder"){
				$new_list_data = array();
				foreach ($list_data as $li) {					
					$li['total'] = $this->db->where(array('sampling_id' => $li['id']))->get('preorder_users')->num_rows(); 
					array_push($new_list_data,$li);
				} 
				return $new_list_data;
			}else{				
				return $list_data;
			}
		}
	}	
	
	public function get_simple_all_lists($key, $type, $status, $parent_id = 0, $parent_type = ""){
		
		$addp = ($status != "all")? "WHERE status = '".$status."'":"WHERE status != 'remove'";
		if($parent_id != 0 && $parent_type != ""){
			$addp .= " AND ".$parent_type."_id = ".$parent_id." ";
		}
				
		$table = $this->get_table($type);
        
    $query = "SELECT ".$key." FROM ".$table." ".$addp." order by create_date desc";		
		$list_data = $this->db->query($query, array())->result_array();
		
		if (!count($list_data)) {
		 	return array();
		}else{
			return $list_data;
		}
	}	
				
	public function get_info($type, $id){
    $table = $this->get_table($type);
    
		$query = "SELECT * FROM ".$table." WHERE id = ?";
		
		$data = $this->db->query($query, array($id))->row_array();
		if (!empty($data)) {
			return $data;
	  }else{
	  	return array();
	  }
	}		
				
	public function edit_info($type, $id, $save_data){			
  	$old_value = $this->get_info($type, $id);
  	
  	$save_data['update_date'] = date('Y-m-d H:i:s');
    
  	$table = $this->get_table($type);
  	
		$result = $this->db->where('id', $id)->update($table, $save_data);
		
		if($result){
			unset($save_data['update_date']);
			foreach ($save_data as $key => $value) {
				if( $old_value[$key] != $save_data[$key]){
			 		$log_info = array('fnc_name' => 'edit_info', 'type' => $type, 'type_id' => $id, 'what' => $key, 'old_value' => $old_value[$key], 'new_value' => $value);
  				$this->insert_user_log($log_info);
  			}
			} 
			return true;
  	}else{
			return false;
  	}
	}		
		
	public function insert_info($type, $save_data){		    	
  	$table = $this->get_table($type);
  	
  	$save_data['create_date'] = date('Y-m-d H:i:s');  
    
  	$result = $this->db->insert($table, $save_data);
  	
  	$id = $this->db->insert_id();
  	if($result){
  		$log_info = array('fnc_name' => 'insert_info', 'type' => $type, 'type_id' => $id, 'new_value' => json_encode($save_data));
  		$this->insert_user_log($log_info);
  		return array('result' => $result, 'id' => $id);
  	}else{
			return array('result' => false);
  	}
	}
	
	public function get_user_register_detail($uid, $type, $type_id){
  	if($type == "workshop"){
			return $this->db->where(array('id' => $uid, 'workshop_id' => $type_id))->get('registration')->row_array();
		}else{
			return $this->db->where(array('id' => $uid, 'sampling_id' => $type_id))->get('sample_users')->row_array();
		}
	}
	
	public function resend_email($type, $save_data, $type_id){
		$new_email = $save_data['user_email']; 
		$uid = $save_data['user_id']; 
		
		$user_detail = $this->get_user_register_detail($uid, $type, $type_id);
		$event_detail = $this->get_info($type, $type_id);	
		
		if(count($event_detail) && count($event_detail) && count($user_detail) && count($user_detail) ){		
			$email_subject = "[RESEND] ".$event_detail['mail_title'];
			$email_body = $event_detail['mail_str'];
			
			if($type == "workshop"){
				$email_body = str_replace("[::workshop_title::]", $event_detail['title'], $email_body);
				$email_body = str_replace("[::user_first_name::]", $user_detail['first_name'], $email_body);
				$email_body = str_replace("[::user_family_name::]", $user_detail['family_name'], $email_body);
				$email_body = str_replace("[::user_nric::]", $user_detail['nric'], $email_body);
				$email_body = str_replace("[::user_contact_number::]", $user_detail['contact_number'], $email_body);			
				$email_body = str_replace("[::user_workshop_day::]", $user_detail['workshop_day'], $email_body);
				$email_body = str_replace("[::user_workshop_time::]", $user_detail['workshop_time'], $email_body);
			}else{
				$qrcode = '<img src="'.$user_detail['qr_code'].'">';
				$email_body = str_replace("[::user_first_name::]", $user_detail['first_name'], $email_body);
				$email_body = str_replace("[::user_family_name::]", $user_detail['family_name'], $email_body);
				$email_body = str_replace("[::user_nric::]", $user_detail['nric'], $email_body);
				$email_body = str_replace("[::user_contact_number::]", $user_detail['contact_number'], $email_body);			
				$email_body = str_replace("[::user_outlet::]", $user_detail['outlet'], $email_body);
				$email_body = str_replace("[::user_qr_code::]", $qrcode, $email_body);
				$email_body = str_replace("[::user_iris_code::]", $user_detail['iris_code'], $email_body);
			}
			
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);
			$this->email->from("sulwhasooSG@iris365.com","Sulwhasoo Singapore");
			$this->email->to($new_email);
			$this->email->subject($email_subject);
			$this->email->message($email_body);
			
			if ($this->email->send()) {
				$str = $email_body;
				$new_type = 'resend-'.$type;
				$this->email_log($uid, $new_email, $str, $new_type);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function email_log($uid, $email, $str, $type){		
		$sent_ata = array( 'reg_id' => $uid, 'email' => $email, 'send_type' => $type, 'email_msg' => $str);
		$result = $this->db->insert("email_logs", $sent_ata);
		if(!$result){
			log_message('error', 'send email log ('.$type.'): '. $uid);
		}
	}
	 			
	public function get_summary_info(){
		$result = array();	
		
		$result['workshop_users'] = $this->db->get('registration')->num_rows();
		$result['workshop_payed_users'] = $this->db->get('payed_registration')->num_rows();
		
		$result['workshops'] = array();		
		$list_data = $this->get_simple_all_lists('id, title', 'workshop', 'active');
		foreach ($list_data as $li) {
			$total = $this->db->where(array('reg_workshop_id' => $li['id']))->get('payed_registration')->num_rows(); 			
			$sub_total_arr = array('total' => $total, 'title' => $li['title']);
			array_push($result['workshops'], $sub_total_arr);
		} 
		
		$result['sample_users'] = $this->db->get('sample_users')->num_rows();
		
    return $result;
	}
	
	public function export_report($report_data){
		header("Content-type: application/vnd.ms-excel; charset=UTF-8");
		header("Content-Disposition: attachment; filename={$report_data['rpt']}_report.xls;");
		header("Pragma: no-cache");
		header("Expires: 0");
		print pack("CCC",0xef,0xbb,0xbf);
		
		if($report_data['rpt'] == "summary"){
			print "<table border=\"1\" cellpadding=\"3\">";
			print "<tr style=\"background-color:#8497BF\">";
			print "<th>Total No. of Workshop Registered Users</th>";
			print "<th>Total No. of Workshop Payed Users</th>";
			print "<th>Total No. of Sampling Registered Users</th>"; 
			print "</tr>";
			print "<tr>";
			print "<td style='vnd.ms-excel.numberformat:@'>";
			print $this->db->where("created_date BETWEEN '".$report_data['start_time']."' AND '".$report_data['end_time']."'")->get('registration')->num_rows(); 
			print "</td><td style='vnd.ms-excel.numberformat:@'>";
			print $this->db->where("created_date BETWEEN '".$report_data['start_time']."' AND '".$report_data['end_time']."'")->get('payed_registration')->num_rows(); 
			print "</td><td style='vnd.ms-excel.numberformat:@'>";
			print $this->db->where("created_date BETWEEN '".$report_data['start_time']."' AND '".$report_data['end_time']."'")->get('sample_users')->num_rows();
			print "</td>";			
			print "</tr>";
			print "</table>";    	
		}else{ 	
			$workshops = array();		
			$list_data = $this->get_simple_all_lists('id, title', 'workshop', 'all');
			foreach ($list_data as $li) {
				$workshops[$li['id']] = $li['title'];
			} 
			
			$sampling = array();		
			$list_data_sampling = $this->get_simple_all_lists('id, title', 'sampling', 'all');
			foreach ($list_data_sampling as $li) {
				$sampling[$li['id']] = $li['title'];
			}  
			
			if($report_data['rpt'] == "registered_users"){
				$sql = "SELECT *, created_date as c_date, id as rid FROM registration where created_date BETWEEN '".$report_data['start_time']."' AND '".$report_data['end_time']."' order by created_date DESC";
			}else if($report_data['rpt'] == "payed_users"){	
				$sql = "SELECT R.*, U.*, R.created_date as c_date, U.id as rid FROM payed_registration R LEFT JOIN registration U ON R.reg_id = U.id where R.created_date BETWEEN '".$report_data['start_time']."' AND '".$report_data['end_time']."' order by R.created_date DESC";
			}else if($report_data['rpt'] == "workshop"){
      	$sql = "SELECT R.*, U.*, R.created_date as c_date, U.id as rid FROM payed_registration R LEFT JOIN registration U ON R.reg_id = U.id where R.reg_workshop_id = ".$report_data['id']." order by R.created_date DESC";
			}else if($report_data['rpt'] == "sample_users"){
      	$sql = "SELECT * FROM sample_users where created_date BETWEEN '".$report_data['start_time']."' AND '".$report_data['end_time']."' order by created_date DESC";
			}else if($report_data['rpt'] == "sampling"){
				$sql = "SELECT * FROM sample_users where sampling_id = ".$report_data['id']." order by created_date DESC";
			}
			
      $results = $this->db->query($sql)->result_array();
			
	    $data = ($results == "") ? array() : $results;
			if (sizeof($data) > 0) {
				print "<table border=\"1\" cellpadding=\"3\">";
				print "<tr style=\"background-color:#8497BF\">";
				
				if($report_data['rpt'] == "registered_users" || $report_data['rpt'] == "payed_users" || $report_data['rpt'] == "workshop"){
					print "<th>ID</th>";		
					print "<th>Workshop</th>";		
					print "<th>Payed</th>";			
					print "<th>Workshop Day</th>";			
					print "<th>Workshop Time</th>";	
					print "<th>First Name</th>";								
					print "<th>Family Name</th>";			
					print "<th>Year of Birth</th>";	
					print "<th>NRIC</th>";
					print "<th>Email</th>";			
					print "<th>Contact Number</th>";		
					print "<th>Device</th>";			
					print "<th>Date Registered</th>";						
					print "</tr>";	
					foreach($data as $k => $v) { 	
						print "<tr>";						
						print "<td style='vnd.ms-excel.numberformat:@'>{$v['rid']}</td>";
						print "<td style='vnd.ms-excel.numberformat:@'>".$workshops[$v['workshop_id']]."</td>";
						print "<td>{$v['payed']}</td>";
						print "<td>{$v['workshop_day']}</td>";
						print "<td>{$v['workshop_time']}</td>";
						print "<td>{$v['first_name']}</td>";
						print "<td>{$v['family_name']}</td>";
						print "<td style='vnd.ms-excel.numberformat:@'>{$v['dob']}</td>";
						print "<td style='vnd.ms-excel.numberformat:@'>{$v['nric']}</td>";
						print "<td>{$v['email']}</td>";
						print "<td>{$v['contact_number']}</td>";
						print "<td>{$v['device']}</td>";
						print "<td>{$v['c_date']}</td>";
						print "</tr>";					
					}					
				}else if($report_data['rpt'] == "sample_users" || $report_data['rpt'] == "sampling"){
					print "<th>Sampling</th>";
					print "<th>Sampling Name</th>";
					print "<th>First Name</th>";								
					print "<th>Family Name</th>";			
					print "<th>Year of Birth</th>";	
					print "<th>NRIC</th>";
					print "<th>Email</th>";			
					print "<th>Contact Number</th>";
					print "<th>Outlet</th>";		
					print "<th>Device</th>";							
					print "<th>IRIS QR Code</th>";
					print "<th>IRIS Unique Code</th>";
					print "<th>Date Registered</th>";						
					print "</tr>";	
					foreach($data as $k => $v) { 	
						print "<tr>";						
						print "<td style='vnd.ms-excel.numberformat:@'>{$v['id']}</td>";
						print "<td style='vnd.ms-excel.numberformat:@'>".$sampling[$v['sampling_id']]."</td>";
						print "<td>{$v['first_name']}</td>";
						print "<td>{$v['family_name']}</td>";
						print "<td style='vnd.ms-excel.numberformat:@'>{$v['dob']}</td>";
						print "<td style='vnd.ms-excel.numberformat:@'>{$v['nric']}</td>";
						print "<td>{$v['email']}</td>";
						print "<td style='vnd.ms-excel.numberformat:@'>{$v['contact_number']}</td>";
						print "<td>{$v['outlet']}</td>";
						print "<td>{$v['device']}</td>";
						print "<td>{$v['qr_code']}</td>";
						print "<td>{$v['iris_code']}</td>";
						print "<td>{$v['created_date']}</td>";
						print "</tr>";					
					}		
				}				
				print "</table>"; 
			} else {
				print "no data";
			}
		}
	}
		  
  public function insert_user_log($log_info){
  	$log_info['change_date'] = date('Y-m-d H:i:s');  	
  	$log_info['changer_id'] = $this->session->userdata('user_id');
  	$log_info['changer_ip'] = $this->session->userdata('ip_address');
  	$this->db->insert('admin_logs', $log_info);
  }    
	
	public function edit_sort($type, $save_data){		
		$sort_arr = explode(",", $save_data['ids']);
  	$table = $this->get_table($type);
  	$update_date = date('Y-m-d H:i:s');
  	$cnt = 0;
  	if(count($sort_arr)){
			foreach ($sort_arr as $value) {
				$cnt++;
			 	$old_value = $this->get_info($type, $value);
				if( $old_value['sort_idx'] != $cnt){
					$result = $this->db->where('id', $value)->update($table, array('sort_idx' => $cnt));				
					if($result){
						$log_info = array('fnc_name' => 'sort', 'type' => $type, 'type_id' => $value, 'what' => 'sort_idx', 'old_value' => $old_value['sort_idx'], 'new_value' => $cnt);
	  				$this->insert_user_log($log_info);
					}
				}	 
			} 			
			return true;
		}else{
			return false;
		}
	}
	
	public function get_sub_active_lists($type, $parent_id = 0, $parent_type = ""){
		$table = $this->get_table($type);
		
		$addp = ($parent_id != 0 &&  $parent_type != "")? "AND ".$parent_type."_id = ".$parent_id:"";
		
		$query = "SELECT * FROM ".$table." WHERE status = 'active' ".$addp." order by sort_idx asc, create_date desc";
			
		$list_data = $this->db->query($query, array())->result_array();
		if (!count($list_data)) {
		 	return array();
		}else{
			return $list_data;
		}
	}
	
	/* only this */  
	function get_class_id($workshop_id, $workshop_day, $workshop_time){
		$where = array(
			'workshop_id' => $workshop_id,
			'workshop_day' => $workshop_day, 
			'workshop_time' => $workshop_time,
			'status' => 'active'
		);
		$row = $this->db->select('id')->where($where)->get('classes')->row_array();
		if(isset($row['id'])){
			return $row['id'];
		}else{
			return 0;
		}	
	}
	
	public function save_cash($type, $type_id, $save_data){   
		
  	$save_data['created_date'] = date('Y-m-d H:i:s');  
    
    $class_id = $this->get_class_id($type_id, $save_data['workshop_day'], $save_data['workshop_time']);
  	$save_data['class_id'] = $class_id;  
    
    if($class_id > 0){
	  	$result = $this->db->insert('registration', $save_data);
	  	
	  	$id = $this->db->insert_id();
	  	if($result){
	  		$log_info = array('fnc_name' => 'save_cash', 'type' => $type, 'type_id' => $id, 'new_value' => json_encode($save_data));
	  		$this->insert_user_log($log_info);
	  		
	  		$payed_save_data = array(
	  			'reg_id' => $id,
	  			'reg_type' => 'cash',
	  			'reg_email' => $save_data['email'],
	  			'reg_workshop_id' => $type_id,
	  			'reg_class_id' => $class_id,
	  			'created_date' => $save_data['created_date']
				);
	  		$result = $this->db->insert('payed_registration', $payed_save_data);
	  		if($result){
	  			$this->cash_send_email($id, $type, $type_id);
	  		}
	  		return $result;
	  	}else{
				return false;
			}
  	}else{
			return false;	
		}
  }    
  
  public function check_save_cash($type_id, $save_data){  
  	$class_id = $this->get_class_id($type_id, $save_data['workshop_day'], $save_data['workshop_time']);
  	
  	$payed_where = array(
			'reg_workshop_id' => $type_id,
			'reg_class_id' => $class_id
		);
		$payed_count = $this->db->where($payed_where)->get('payed_registration')->num_rows();
				
		$min_before = date("Y-m-d H:i:s", strtotime("-30 minutes"));		
		$registration_where = "workshop_id = ".$type_id." ";
		$registration_where .= "and class_id = ".$class_id." ";
		$registration_where .= "and payed = 'no' ";
		$registration_where .= "and created_date > '".$min_before."'";
		
		$registration_count = $this->db->where($registration_where)->get('registration')->num_rows();
		 
		$row = $this->db->select('slots')->where('id', $type_id)->get('workshops')->row_array();
		if(!isset($row['slots'])){
			return true;
		}else if(intval($row['slots']) > (intval($payed_count) + intval($registration_count ))){
			return false;
		}else{
			return true;
		}
	} 
	
	public function cash_send_email($reg_id, $type, $type_id){		
		$user_detail = $this->get_user_register_detail($reg_id, $type, $type_id);
		$event_detail = $this->get_info($type, $type_id);	
		
		if(count($event_detail) && count($event_detail) && count($user_detail) && count($user_detail) ){		
			$email_subject = $event_detail['mail_title'];
			$email_body = $event_detail['mail_str'];
			
			if($type == "workshop"){
				$email_body = str_replace("[::workshop_title::]", $event_detail['title'], $email_body);
				$email_body = str_replace("[::user_first_name::]", $user_detail['first_name'], $email_body);
				$email_body = str_replace("[::user_family_name::]", $user_detail['family_name'], $email_body);
				$email_body = str_replace("[::user_nric::]", $user_detail['nric'], $email_body);
				$email_body = str_replace("[::user_contact_number::]", $user_detail['contact_number'], $email_body);			
				$email_body = str_replace("[::user_workshop_day::]", $user_detail['workshop_day'], $email_body);
				$email_body = str_replace("[::user_workshop_time::]", $user_detail['workshop_time'], $email_body);
			}else{
				//
			}
			
			$this->load->library('email');
			$config['mailtype'] = "html";
			$this->email->initialize($config);
			$this->email->from("sulwhasooSG@iris365.com","Sulwhasoo Singapore");
			$this->email->to($user_detail['email']);
			$this->email->subject($email_subject);
			$this->email->message($email_body);
			
			if ($this->email->send()) {
				$str = $email_body;				
				$new_type = 'cash-'.$type;
				$this->email_log($reg_id, $user_detail['email'], $str, $new_type);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function redemption_update(){
  	$url = "http://login.irisrewards.com/reward-admin/?c=redemption&m=get_un_reminder_list";	
  	$post_data = array(
			'id' => 9,	
			'token' => 'get_un_reminder_list',
			'item_code' => 'SulwhasooSG_GRC'
		);
		
		$result = $this->CallAPI('POST', $url, $post_data);
		$result = json_decode($result, true);
		if($result['error'] == 0){
			$ids = "";
			if(count($result['data'])){
				foreach ($result['data'] as $d) {
					if(intval($d['id']) > 6982){
						$ids .= ($ids == "")? $d['id']:",".$d['id'];
					}
				} 
				if($ids != ""){	
					/*
					$sql = "Update sample_users SET iris_redemption = 'done' WHERE sampling_id = 1 and iris_id in (".$ids.")"; 
					$this->db->query($sql);  	
		  		*/
					$query = "SELECT * FROM sample_users WHERE sampling_id = 1 and iris_id in (".$ids.") order by id asc";
					$data = $this->db->query($query)->result_array();
		  		echo count($data);
		  		exit;
				}
			}
		}
  }
  
  public function reminder_send(){
  	/*
  	//reminder update
  	$this->redemption_update();
  	return true;
  	*/
  	/*
  	//reminder send
  	$total = $this->db->where(array('reminder_send' => 'no', 'id' => 1))->get('samplings')->num_rows(); 
  	if($total == 1){
	  	$up_result = $this->db->where('id', 1)->update('samplings', array('reminder_send' => 'yes'));
	  	if($up_result){  //yet //test
	  		$query = "SELECT * FROM sample_users WHERE iris_redemption = 'yet' and iris_reminder = 'yet' and sampling_id = 1 order by id asc";
		  	$data = $this->db->query($query)->result_array();
		  	//echo count($data);
		  	//exit;
		  	
		  	//
		  	if(count($data)){
					foreach ($data as $user_detail) {
					 	$email_subject = "Redemption of Sulwhasoo Complimentary Anti-Aging Kit."; 
						$email_body = "<p>Hi ".$user_detail['first_name']." ".$user_detail['family_name'].", </p>
							<p>Thank you for taking part in the Sulwhasoo Complimentary Anti-Aging Kit. You are entitled to redeem your trial kit.</p>
							<p>We have noticed that you have not redeemed your Sulwhasoo Complimentary Anti-Aging Kit*. Your trial kit will be ready for collection only at Sulwhasoo booth at ION Orchard L1 Atrium from <b>now till 6th September 2017</b>. You may redeem your trial kit by presenting the QR Code below.</p>
							<p><b>Strictly one redemption is allowed per person.</b></p>
							<p>The Organizer reserves the right to request written proof of NRIC number before collection of trial kit. The Organizer reserves the right to forfeit the campaign for any fans who do not provide the required details upon receiving the request/notification from the Organizer.  </p>
							<p>Trial kit are not exchangeable, transferable or redeemable in any other form for whatever reason.  </p>
							<p>Please present the email upon redemption.   </p>
							<p>QR Code : <img src='".$user_detail['qr_code']."'>
							<br>Unique Code :". $user_detail['iris_code']."</p>
							<p>Terms and Conditions apply.</p>
							<p>*While stocks last.</p>
							<p>Regards,
							<br>Sulwhasoo Singapore</p>
						";			
						$this->load->library('email');
						$config['mailtype'] = "html";
						$this->email->initialize($config);
						$this->email->from("sulwhasooSG@iris365.com","Sulwhasoo Singapore");
						$this->email->to($user_detail['email']);
						$this->email->subject($email_subject);
						$this->email->message($email_body);
							
						if ($this->email->send()) {
							$sql = "Update sample_users SET iris_reminder = 'sent' WHERE id = ".$user_detail['id'];
  						$this->db->query($sql);  	
						}
					} 
					return true;
				}else{
					return false;
				}	
				//
				
	  	}else{
	  		return false;
	  	}
		}else{
			return false;
		}
		*/
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
}

?>
