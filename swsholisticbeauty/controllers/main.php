<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('workshops');
		//Phase 2
		$this->load->model('samplings');
	}
	
	public function index()
	{
		$this->about();
	}
	
	function about(){
		$this->view('about');
	}
	
	function workshop(){
		$data['thanks'] = 'no';
		$data['copies'] = $this->workshops->get_copies();
		$data['workshops'] = $this->workshops->get_workshop_list();
		$this->view('workshop', $data);
	}
	
	function preview(){
		$data['thanks'] = 'no';
		$data['copies'] = $this->workshops->get_copies();
		$data['workshops'] = $this->workshops->get_workshop_preview();
		$this->view('workshop', $data);
	}
	
	function thanks(){
		$this->load->model('payments');		
		
		if(isset($_REQUEST['tx'])){
			$token = $_REQUEST['tx'];
			log_message('error', 'tx : '.$token);
			
			$reg_id = $this->input->get('reg_id');
			log_message('error', 'reg id : '.$reg_id);
			
			$data['thanks'] = $this->payments->record_payment($reg_id, $token);
			
			if($data['thanks'] == 'yes'){
				$this->load->helper('url');
				redirect('/thanks?reg_id='.$reg_id, 'refresh');
			}else{
				redirect('/', 'refresh');
			}
		}else{			
			if(isset($_REQUEST['reg_id'])){		
				$reg_id = $this->input->get('reg_id');
				$reg_info = $this->workshops->user_reg_info_by_id($reg_id);
				$data['thanks_id'] = $reg_info['workshop_id'];
				$data['thanks'] = ($reg_info['payed'] == 'yes')? 'yes':'no';
			}else{
				$data['thanks'] = 'no';
			}
		}
		
		$data['copies'] = $this->workshops->get_copies();
		$data['workshops'] = $this->workshops->get_workshop_list();
		$this->view('workshop', $data);
	}
	
	function ipn(){
		$this->load->model('payments');	
		
		$payment_data = $this->input->post();
		log_message('error', 'payment data : '.json_encode($payment_data));
		
		$this->payments->record_payment_ipn($payment_data);
	}
	
	//Phase 2
	function sampling(){
		$this->view('sampling');		
	}
	
	function trialkit(){
		$this->view('sampling');		
	}

	function preorder(){
		$this->view('preorder');		
	}
		
  protected function view($name, $data = array()) {	
  		if ($name == 'preorder') {
  				//Phase 2
				// var_dump($name);exit();
				$data['sampling'] = $this->samplings->get_preorder();
				// var_dump($data);exit();
				// print_r($data['sampling']);
				$view_data['view_name'] = $name;
				$view_data['view_data'] = $data;
				// var_dump($view_data);exit();
				$this->load->view('view', $view_data);
  			}else{
  				//Phase 2
				// var_dump($name);exit();
				$data['sampling'] = $this->samplings->get_sampling();
				// var_dump($data);exit();
				// print_r($data['sampling']);
				$view_data['view_name'] = $name;
				$view_data['view_data'] = $data;
				// var_dump($view_data);exit();
				$this->load->view('view', $view_data);
  			}	
		
	}
}

/* End of file main.php */
/* Location: controllers/main.php */