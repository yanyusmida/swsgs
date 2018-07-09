<?php

/**
 * Description of user
 *
 * @author abby.kim
 */
class Workshops extends CI_Model {

	private $_registration;
	private $_payed_registration;
	private $_classes;
	private $_workshops;
	private $_copies;

	public function __construct() {
		parent::__construct();
		
		$this->_registration = $this->db->dbprefix("registration");
		$this->_payed_registration = $this->db->dbprefix("payed_registration");
		$this->_classes = $this->db->dbprefix("classes");
		$this->_workshops = $this->db->dbprefix("workshops");
		$this->_copies = $this->db->dbprefix("copies");
	}
	
	public function get_copies(){
  	$query = "SELECT * FROM {$this->_copies} WHERE type_name = 'workshop' order by id asc";
		$data = $this->db->query($query, array())->result_array();
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
		
	function is_closed($workshop_id) {
		$row = $this->get_workshop_selection($workshop_id, 'end_date');
		if(!isset($row['end_date'])){
			log_message('error', 'is_closed return null');
			return true;
		}else if(date('Y-m-d H:i:s') > $row['end_date']){
			return true;
		}else{
			return false;
		}	
	}
	
	function get_end_msg($workshop_id) {
		$row = $this->get_workshop_selection($workshop_id, 'end_msg');
		if(isset($row['end_msg'])){
			return $row['end_msg'];
		}else{
			log_message('error', 'get_end_msg return null');
			return 'Sorry! The workshop slots are all filled.';
		}	
	}
	
	function get_class_id($workshop_id, $workshop_day, $workshop_time){
		$where = array(
			'workshop_id' => $workshop_id,
			'workshop_day' => $workshop_day, 
			'workshop_time' => $workshop_time,
			'status' => 'active'
		);
		$row = $this->db->select('id')->where($where)->get($this->_classes)->row_array();
		if(isset($row['id'])){
			return $row['id'];
		}else{
			log_message('error', 'get_class_id return null');
			return 0;
		}	
	}
	
	function get_payed_count($workshop_id, $class_id){
		$payed_where = array(
			'reg_workshop_id' => $workshop_id,
			'reg_class_id' => $class_id
		);
		return $this->db->where($payed_where)->get($this->_payed_registration)->num_rows();
	}
		
	function is_over($user_data){
		$payed_where = array(
			'reg_workshop_id' => $user_data['workshop_id'],
			'reg_class_id' => $user_data['class_id']
		);
		$payed_count = $this->db->where($payed_where)->get($this->_payed_registration)->num_rows();
				
		$min_before = date("Y-m-d H:i:s", strtotime("-30 minutes"));		
		$registration_where = "workshop_id = ".$user_data['workshop_id']." ";
		$registration_where .= "and class_id = ".$user_data['class_id']." ";
		$registration_where .= "and payed = 'no' ";
		$registration_where .= "and created_date > '".$min_before."'";
		
		$registration_count = $this->db->where($registration_where)->get($this->_registration)->num_rows();
		 
		$row = $this->get_workshop_selection($user_data['workshop_id'], 'slots');
		if(!isset($row['slots'])){
			log_message('error', 'is_over return null');
			return true;
		}else if(intval($row['slots']) > (intval($payed_count) + intval($registration_count ))){
			return false;
		}else{
			return true;
		}
	}
	
	public function get_workshop_selection($workshop_id, $select){
		return $this->db->select($select)->where('id', $workshop_id)->get($this->_workshops)->row_array();
	}
	
	public function get_workshop($workshop_id){
		return $this->db->where('id', $workshop_id)->get($this->_workshops)->row_array();
	}
	
	public function get_workshop_list(){
		$now = date("Y-m-d H:i:s");		
		$where = "status = 'active' and start_date < '".$now."'";
		$result_array = $this->db->where($where)->order_by('sort_idx asc')->get($this->_workshops)->result_array();
		foreach ($result_array as &$workshop) {
		 	 $workshop['classes'] = $this->get_classes($workshop['id']);
		} 
		//$this->output->enable_profiler(TRUE);
		return $result_array;
	}
	
	public function get_workshop_preview(){
		$now = date("Y-m-d H:i:s");		
		$where = "status = 'active' and start_date > '".$now."'";
		$result_array = $this->db->where($where)->order_by('sort_idx asc')->get($this->_workshops)->result_array();
		foreach ($result_array as &$workshop) {
		 	 $workshop['classes'] = $this->get_classes($workshop['id']);
		} 
		return $result_array;
	}
	
	public function get_classes($workshop_id){
		$where = array(
			'workshop_id' => $workshop_id,
			'status' => 'active' 
		);
		return $this->db->where($where)->order_by('sort_idx asc, create_date desc, id asc')->get($this->_classes)->result_array();
	}
	
	public function check_have_reg_email($user_data){
		$payed_where = array(
			'reg_workshop_id' => $user_data['workshop_id'],
			'reg_email' => $user_data['email']
		);
		$payed_count = $this->db->where($payed_where)->get($this->_payed_registration)->num_rows();
		
		return ($payed_count > 0)? false:true;
	}
	
	public function insert_reg($user_data) {
		$data = $this->pre_resolve_data($user_data);
		$this->load->library('user_agent');
		$user_agent = $this->agent->agent_string();
		$mobile_agent = '/(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS|xiaomi|XiaoMi|MiuiBrowser)/';
		$data['device'] = ( preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) ? "MOBILE":"PC";		
				
		return $this->db->insert($this->_registration, $data);
	}
	
	public function user_reg_info($email, $created_date){
		$where = array(
			'email' => $email, 
			'created_date' => $created_date
		);
		return $this->db->where($where)->get($this->_registration)->row_array();
	}
	
	public function user_reg_info_by_id($reg_id){
		return $this->db->where('id',$reg_id)->get($this->_registration)->row_array();
	}
	
	/**
	* 去掉data不存在table里的field的key.
	* @param Array $data
	* @param String $prefix 是否加上前缀后匹配
	* @return Array
	*/	
	function pre_resolve_data($data, $prefix='') {
		$user_fields = $this->db->list_fields($this->_registration);
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
	
}

?>
