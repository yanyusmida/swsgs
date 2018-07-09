<?php

/**
 * @auther Abby(mizitear@naver.com)
 * @copyright	Copyright (c) 2012, IgniteLab, Inc.
 * @filesource
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends CI_Controller {
	private $_have_sess;
	private $_have_admin_sess;
	
	public function __construct() {
		parent::__construct();
		$this->load->model('admins');
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
		$result = array("error" => 1, 'msg' => 'Failed #101');
		echo json_encode($result);
	}

	function status() {
		if($this->_have_sess || $this->_have_admin_sess){
			$save_data = $this->input->post();	
			if(!empty($save_data)){		
				$status_save_data	= array('status' => $save_data['new_status']);
				if($this->admins->edit_info($save_data['do_type'], $save_data['type_id'], $status_save_data)){
					$result = array("error" => 0, 'msg' => 'Success');
					echo json_encode($result);
				}else{
					$result = array("error" => 1, 'msg' => 'Failed #203');
					echo json_encode($result);
				}
			}else{
				$result = array("error" => 1, 'msg' => 'Failed #202');
				echo json_encode($result);
			}
		}else{
			$result = array("error" => 1, 'msg' => 'Failed #201');
			echo json_encode($result);
		}
	}	
}

?>
