<?php

/**
 * @auther Abby(mizitear@naver.com)
 * @copyright	Copyright (c) 2012, IgniteLab, Inc.
 * @filesource
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {
	private $_have_sess;
	private $_have_admin_sess;
	
	public function __construct() {
		parent::__construct();
		$this->load->model('admins');
		$this->load->model('users');
		$this->_have_sess = $this->session_check();
		$this->_have_admin_sess = $this->admin_session_check();
	}
	
	function session_check(){
		$admin_login = $this->session->userdata('user_id');
		if (isset($admin_login) && $admin_login != ""){
			return true;
		}else{
			return false;
		}
	}
	
	function admin_session_check(){
		$admin_login = $this->session->userdata('user_type');
		if (isset($admin_login) && $admin_login == "admin"){
			return true;
		}else{
			return false;
		}
	}
	
	function index() {
		// var_dump($this->_have_sess);exit();
		if ($this->_have_sess){				
			$this->go_default();
		}else if($this->input->post('username') && $this->input->post('password')) {
			$admin_id = $this->input->post('username');
			$admin_pw = $this->input->post('password');
			if($this->users->login_check($admin_id, $admin_pw)){
				$admin_info = $this->users->get_user_info($admin_id);
				$this->session->set_userdata('user_id',$admin_info['user_id']);
				$this->session->set_userdata('user_type',$admin_info['user_type']);
				$this->go_default();
			}else{
				$data['message'] = "incorrect username or password";
				$this->load->view('login', $data);
			}
		}else{
			$this->load->view('login');
		}		
	}

	function logout() {
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_type');
		$this->load->view('login');
	}
		
	function summary(){		
		if($this->_have_sess){
			$data['summary'] = $this->admins->get_summary_info();		
			$data['show_page'] = "summary";
			$data['show_menu'] = "summary";
			$this->load->view('summary', $data);
		}else{
			$this->load->view('login');
		}	
	}	
		
	function report(){
		if($this->_have_sess || $this->_have_admin_sess){
			$report_data = $this->input->post();
			$report_get_data = $this->input->get();
			if(!empty($report_data)){		
				$this->admins->export_report($report_data);	
			}else if(!empty($report_get_data)){		
				$this->admins->export_report($report_get_data);	
			}else{
				$data['show_page'] = "report";
				$data['show_menu'] = "report";
				$this->load->view('report', $data);
			}
		}else{
			$this->load->view('login');
		}	
	}	
			
	function save_picture($file_name, $save_path, $save_name, $type){		
		$this->load->library('image_lib');
		$this->load->library('upload');				
		$config['upload_path'] = $save_path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '0';
		$config['max_width']  = '0';
		$config['max_height']  = '0';      
		$this->upload->initialize($config);	
		
		if(is_uploaded_file($_FILES[$file_name]['tmp_name'])){		
			$save_format = explode(".", $save_name);
			$old = $save_format[0].time().".".$save_format[1];
			$vname = $save_format;
			try{
				rename($save_path.$save_name, $save_path.$old);
		  } catch (Exception $e) {
		  	log_message('error', "save_picture ( ".$save_name." )-->" . $e);
		  }     	 
		  	
			if ($this->upload->do_upload($file_name)){
				$data = array('upload_data' => $this->upload->data());
				$file = $data['upload_data']['file_name'];                
				rename($save_path.$file, $save_path.$save_name);
				
				$log_info = array('type' => $type, 'fnc_name' => 'save_image', 'what' => $file_name, 'old_value' => $old, 'new_value' => $save_name);
  			$this->admins->insert_user_log($log_info);
			}
		}
	}	
					
	function lists($type){
		// var_dump($type);exit();
		// 如果有登录才允许继续访问
		if($this->_have_sess){

			$filter_data = $this->input->post();	// false
			// var_dump($filter_data);exit();
			$data['page'] = (isset($filter_data['page']))? $filter_data['page']:0;
			
			$data['page'] = intval($data['page']);	//0
			$data['filter'] = (isset($filter_data['filter']))? $filter_data['filter']:"all";	//all
			
			$data['status'] = (isset($filter_data['status']))? $filter_data['status']:"all";		//all	

			$data['lists'] = $this->admins->get_lists($type, $data['filter'], $data['status'], $data['page']);	
			// $type: preorder filter :all status:all page:0
			

			$data['total'] = $this->admins->get_list_tot($type, $data['filter'], $data['status']);	

			$data['type'] = $type;		
			$data['show_page'] = $type;		
			$data['show_menu'] = $type."_list";
			// var_dump($data);exit();
			$this->load->view( $type."_list", $data);
		}else{
			$this->load->view('login');
		}
	}
	
	function create($type){
		if($this->_have_sess || $this->_have_admin_sess){
			$save_data = $this->input->post();	
			if(!empty($save_data)){	
				if($type == "workshop"){
					$key = "banner_img";
					$save_name = "banner_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['banner_img'] = $save_name;
					}		
					
					$key = "workshop_img";
					$save_name = "workshop_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['workshop_img'] = $save_name;
					}		
				}else if($type == "sampling"){	
					$key = "banner_img";
					$save_name = "banner_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['banner_img'] = $save_name;
					}		
					
					$key = "sampling_img";
					$save_name = "sampling_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['sampling_img'] = $save_name;
					}							
				}else if($type == "preorder"){	
					$key = "banner_img";
					$save_name = "banner_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['banner_img'] = $save_name;
					}		
					
					$key = "sampling_img";
					$save_name = "sampling_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['sampling_img'] = $save_name;
					}							
				}
				
				$result = $this->admins->insert_info($type, $save_data);
				$msg = ($result['result'])? "Success":"failed";
				$data['message'] = $msg;
				$data['refresh'] = true;
			}		
			$data['type'] = $type;		
			$data['show_page'] = $type;
			$data['show_menu'] = $type."_create";
			$this->load->view($type.'_create', $data);
		}else{
			$this->load->view('login');
		}
	}	
	
	function edit($type,$id){
		if($this->_have_sess || $this->_have_admin_sess){
			$save_data = $this->input->post();	

			if(!empty($save_data)){	
				if($type == "workshop"){
					$key = "banner_img";
					$save_name = "banner_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['banner_img'] = $save_name;
					}			
					
					$key = "workshop_img";
					$save_name = "workshop_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['workshop_img'] = $save_name;
					}		
				}else if($type == "sampling"){
					$key = "banner_img";
					$save_name = "banner_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['banner_img'] = $save_name;
					}			
					
					$key = "sampling_img";
					$save_name = "sampling_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['sampling_img'] = $save_name;
					}		
				}else if($type == "preorder"){
					$key = "banner_img";
					$save_name = "banner_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['banner_img'] = $save_name;
					}			
					
					$key = "sampling_img";
					$save_name = "sampling_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $type);
						$save_data['sampling_img'] = $save_name;
					}		
				}
								
				$result = $this->admins->edit_info($type, $id, $save_data);
				$msg = ($result)? "Success":"failed";
				$data['message'] = $msg;
				$data['refresh'] = true;	
			}			
			$data['show_info'] = $this->admins->get_info($type, $id);

			// var_dump($type);exit();	
			$data['type'] = $type;			
			$data['show_page'] = $type;
			$data['show_menu'] = $type."_edit";
			$this->load->view($type."_edit", $data);
		}else{
			$this->load->view('login');
		}
	}	
	
	function slist($type,$id){
		if($this->_have_sess){
			$filter_data = $this->input->post();		
			$data['page'] = (isset($filter_data['page']))? $filter_data['page']:0;
			$data['page'] = intval($data['page']);	
			$data['status'] = (isset($filter_data['status']))? $filter_data['status']:"all";		
			if($type == "workshop"){					
				$data['lists'] = $this->admins->get_lists("class", $data['status'], $data['status'], $data['page'], $id, $type);	
				$data['total'] = $this->admins->get_list_tot("class", $data['status'], $data['status'], $id, $type);	
			}else{
				$data['lists'] = $this->admins->get_lists($type, $data['status'], $data['status'], $data['page'], $id, $type);	
				$data['total'] = $this->admins->get_list_tot($type, $data['status'], $data['status'], $id, $type);	
			}
			$data['parent_info'] = $this->admins->get_info($type, $id);		
			$data['parent_id'] = $id;			
			$data['type'] = $type;		
			$data['show_page'] = $type;		
			$data['show_menu'] = $type."_sub_list";
			$this->load->view( $type."_sub_list", $data);
		}else{
			$this->load->view('login');
		}
	}
	
	function screate($type,$id){
		if($this->_have_sess){
			$save_data = $this->input->post();	
			if(!empty($save_data)){	
				if($type == "workshop"){			
					$result['result'] = true;
					for ($i = 0; $i < $save_data['total_time']; $i++) {
						$idx = $i + 1;
						if(isset($save_data['workshop_time_'.$idx]) && $save_data['workshop_time_'.$idx] != ""){
							$class_save_data = array(
								'workshop_id' => $save_data['workshop_id'],
								'workshop_day' => $save_data['workshop_day'],
								'workshop_time' => $save_data['workshop_time_'.$idx],
								'status' => 'active'
							);
							$this->admins->insert_info("class", $class_save_data);
						}
					}					
				}else{	
					$result = $this->admins->insert_info($type, $save_data);
				}
				$msg = ($result['result'])? "Success":"failed";
				$data['message'] = $msg;
				$data['refresh'] = true;
			}		
			$data['parent_info'] = $this->admins->get_info($type, $id);	
			$data['parent_id'] = $id;			
			$data['type'] = $type;		
			$data['show_page'] = $type;
			$data['show_menu'] = $type."_sub_create";
			$this->load->view($type.'_sub_create', $data);
		}else{
			$this->load->view('login');
		}
	}	
			
	function resend($type,$id){
		if($this->_have_sess || $this->_have_admin_sess){
			$save_data = $this->input->post();	
			if(!empty($save_data)){	
				$result = $this->admins->resend_email($type, $save_data, $id);
				$msg = ($result)? "Success":"failed";
				$data['message'] = $msg;
				$data['refresh'] = true;
			}	
			$data['parent_info'] = $this->admins->get_info($type, $id);	
			$data['parent_id'] = $id;			
			$data['type'] = $type;			
			$data['show_page'] = $type;
			$data['show_menu'] = $type."_resend";
			$this->load->view($type."_resend", $data);
		}else{
			$this->load->view('login');
		}
	}
	
	function cash($type,$id){
		if($this->_have_sess){
			$save_data = $this->input->post();	
			if(!empty($save_data)){	
				if($this->admins->check_save_cash($id, $save_data)){
					$msg = "Sorry! The workshop slots for the timing you prefer is full. Please select an alternative timing.";
				}else{
					$result = $this->admins->save_cash($type, $id, $save_data);
					$msg = ($result)? "Success":"failed";
				}
				$data['message'] = $msg;
				$data['refresh'] = true;
			}	
			$data['classes'] = $this->admins->get_simple_all_lists("*", "class", "active", $id, $type);
			$data['parent_info'] = $this->admins->get_info($type, $id);	
			$data['parent_id'] = $id;			
			$data['type'] = $type;			
			$data['show_page'] = $type;
			$data['show_menu'] = $type."_cash";
			$this->load->view($type."_cash", $data);
		}else{
			$this->load->view('login');
		}
	}
	
	function psort($type){
		if($this->_have_sess || $this->_have_admin_sess){
			$save_data = $this->input->post();	
			if(!empty($save_data)){					
				$result = $this->admins->edit_sort($type, $save_data);
				$msg = ($result)? "Success":"failed";
				$data['message'] = $msg;
				$data['refresh'] = true;
			}
			$data['lists'] = $this->admins->get_sub_active_lists($type);
			$data['type'] = $type;			
			$data['show_page'] = $type;
			$data['show_menu'] = $type."_sort";
			$this->load->view($type."_sort", $data);
		}else{
			$this->load->view('login');
		}
	}
	
	function ssort($type,$id){
		if($this->_have_sess || $this->_have_admin_sess){
			$save_data = $this->input->post();	
			if(!empty($save_data)){					
				$result = $this->admins->edit_sort("class", $save_data);
				$msg = ($result)? "Success":"failed";
				$data['message'] = $msg;
				$data['refresh'] = true;
			}
			$data['lists'] = $this->admins->get_sub_active_lists("class", $id, $type);
			$data['parent_info'] = $this->admins->get_info($type, $id);	
			$data['parent_id'] = $id;		
			$data['type'] = $type;			
			$data['show_page'] = $type;
			$data['show_menu'] = $type."_sub_sort";
			$this->load->view($type."_sub_sort", $data);
		}else{
			$this->load->view('login');
		}
	}
	
	function set_theme($view_type){
		if($this->_have_sess || $this->_have_admin_sess){
			$theme_data = $this->input->post();	
			$view_type = "workshop";
			if(!empty($theme_data)){		
				if($view_type == "workshop"){					
					$key = "workshop_header_img";
					$save_name = "workshop_header_img_".time().".jpg";
					if(is_uploaded_file($_FILES[$key]['tmp_name'])){
						$save_path = "../".config_item('app_base_directory')."uploads/";
						$this->save_picture($key, $save_path, $save_name, $view_type);
						$theme_data['workshop_header_img'] = $save_name;
					}
				}
				$result = $this->admins->edit_theme_info($view_type, $theme_data);
				
				$msg = ($result)? "Success":"failed";
				$data['message'] = $msg;
				$data['refresh'] = true;	
			}			
			$data['theme_info'] = $this->admins->get_theme_values($view_type);	
			$view_type = "setting";
			$data['view_type'] = $view_type;		
			$data['show_page'] = "theme";	
			$data['show_menu'] = $view_type;
			$this->load->view('theme', $data);
		}else{
			$this->load->view('login');
		}	
	}
	
	function reminder(){
		if($this->_have_sess){
			if($this->session->userdata('user_id') == "mizitear"){
				$result = $this->admins->reminder_send();
				$msg = ($result)? "Success":"failed";
				$data['message'] = $msg;
				$data['refresh'] = true;	
				
				$data['show_page'] = "reminder";
				$data['show_menu'] = "reminder";
				$this->load->view('reminder', $data);	
			}else{
				$this->go_default();
			}
		}else{
			$this->load->view('login');
		}
	}
						
	function go_default($msg = null, $refresh = false){
		if($msg != null){
			$data['message'] = $msg;
		}
		if($refresh){
			$data['refresh'] = true;
		}
		
		$data['summary'] = $this->admins->get_summary_info();		
		$data['show_page'] = "summary";
		$data['show_menu'] = "summary";
		// var_dump($data['summary']);exit();
		$this->load->view('summary', $data);
	}
}

?>
