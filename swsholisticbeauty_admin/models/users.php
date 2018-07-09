<?php

/**
 * Description of user
 *
 * @author Abby.Kim
 */
class Users extends CI_Model {

	private $_mamber;
    
	public function __construct() {
		parent::__construct();
		$this->_mamber = $this->db->dbprefix('admin_mambers');
	}
    
	public function login_check($id, $pw){
		$query = "SELECT id FROM {$this->_mamber} WHERE user_id = ? AND user_pw = MD5('".$pw."')";
		$data = $this->db->query($query, array($id, $pw))->row_array();
		if (!empty($data)) {
			return true; //is member
	  }
		return false;
  }
    
  public function get_user_info($user_id){    	
		$query = "SELECT id, user_id, user_type FROM {$this->_mamber} WHERE user_id = ?";
		$data = $this->db->query($query, array($user_id))->row_array();
		if (!empty($data)) {
			return $data;
	  }else{
	  	return array('user_id' => $id);
	  }
  }    
}

?>
