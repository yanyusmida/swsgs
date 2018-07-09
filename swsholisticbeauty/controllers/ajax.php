<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('workshops');
	}
		
	function registration(){
		$user_data = $this->input->get();
		$workshop_id = $user_data['workshop_id'];
		if ($this->workshops->is_closed($workshop_id)) {
			$result = array("error" => 1, 'msg' => $this->workshops->get_end_msg($workshop_id));		
		}else{			
			if(!empty($user_data)){	
				$user_data['class_id'] = $this->workshops->get_class_id($workshop_id, $user_data['workshop_day'], $user_data['workshop_time']);
				if($user_data['class_id'] == 0 || $this->workshops->is_over($user_data)){
					$result = array("error" => 1, 'msg' => 'Sorry! The workshop slots for the timing you prefer is full. Please select an alternative timing.');
				}else{
					$user_data['created_date'] = date('Y-m-d H:i:s');
					if($this->workshops->check_have_reg_email($user_data)){
						if ($this->workshops->insert_reg($user_data)) { 
							$user_info = $this->workshops->user_reg_info($user_data['email'], $user_data['created_date'] ); 
							if (isset($user_info['id'])) {
								$result = array("error" => 0, 'msg' => 'Success', 'reg_id' => $user_info['id'], 'workshop_id' => $workshop_id);
							}else{
								log_message('error', 'signup #103: -->' . json_encode($user_data));
								$result = array("error" => 1, 'msg' => 'Failed #103');
							}
						}else{
							$result = array("error" => 1, 'msg' => 'Failed #102');
						}	
					}else{
						$result = array("error" => 1, 'msg' => 'Sorry, it looks like the email belongs to an existing account.');		
					}	 
				}
			}else{
				$result = array("error" => 1, 'msg' => 'Failed #101');
			}
		}
		echo json_encode($result);
	}
	
	function reg_sampling(){
		$user_data = $this->input->get();
		$sampling_id = $user_data['sampling_id'];
		$this->load->model('samplings');
		if ($this->samplings->is_closed($sampling_id)) {
			$result = array("error" => 1, 'msg' => $this->samplings->get_end_msg($sampling_id));
		}else if($this->samplings->is_over($sampling_id)){
			$result = array("error" => 1, 'msg' => $this->samplings->get_over_msg($sampling_id));
		}else{		
			if(!empty($user_data)){	
				if($this->samplings->check_have_reg_email($user_data['email'])){
					if ($this->samplings->insert_reg($user_data)) { 
						$user_info = $this->samplings->user_reg_info($user_data['email']); 
						if (!empty($user_info)) {
							$result = array("error" => 0, 'msg' => 'Success');
						}else{
							log_message('error', 'signup #203: -->' . json_encode($user_data));
							$result = array("error" => 1, 'msg' => 'Failed #203');
						}
					}else{
						$result = array("error" => 1, 'msg' => 'Failed #202');
					}	
				}else{
					$result = array("error" => 1, 'msg' => 'Thank You For Your Interest!<br><small style="color: white;"> Sorry, we noticed you have already registered for your complimentary kit. </small>');		
				}	 
			}else{
				$result = array("error" => 1, 'msg' => 'Failed #201');
			}
		}
		echo json_encode($result);
	}

	// msm send
	// user_data:
	// array(10) {
	//   ["preorder_id"]=>
	//   string(1) "2"
	//   ["first_name"]=>
	//   string(3) "111"
	//   ["family_name"]=>
	//   string(3) "121"
	//   ["contact_number"]=>
	//   string(8) "11111111"
	//   ["nric"]=>
	//   string(4) "1111"
	//   ["dob"]=>
	//   string(4) "2001"
	//   ["email"]=>
	//   string(18) "yanyusmida@163.com"
	//   ["outlet"]=>
	//   string(11) "ION Orchard"
	//   ["check-tc"]=>
	//   string(3) "yes"
	//   ["_"]=>
	//   string(13) "1530778668357"
	// }

	function send_sms(){
		//获得表单数据
		$user_data = $this->input->get();
		// var_dump($user_data);exit();
		$preorder_id = $user_data['preorder_id'];
		// 引入模型samplings
		$this->load->model('samplings');
		//验证日期是否过期和注册数量是否超过限制
		if ($this->samplings->is_closed_preorder($preorder_id)) {
			$result = array("error" => 1, 'msg' => $this->samplings->get_end_msg_preorder($preorder_id));
		}else if($this->samplings->is_over_preorder($preorder_id)){
			$result = array("error" => 1, 'msg' => $this->samplings->get_over_msg_preorder($preorder_id));
		}else{		
			if(!empty($user_data)){	
				//验证电话是否已注册过
				if($this->samplings->check_have_reg_email_preorder($user_data['contact_number'])){
					//将表格接收的用户数据添加到数据库以后再发送短信
					$res = $this->samplings->add_phone($user_data);
					// var_dump($res);exit();
					if ($res) {

						//send_message($appid,$appsecret,$receivers,$content)
						// receivers联系号码
						// content短信内容
						$str = '这是一条测试信息，请忽略谢谢';
						$res = $this->samplings->send_message('2818','25625fa1-2b65-4fd9-9f4a-b226b9299612','+6597903507',$str);
						
						if ($res === FALSE) {
							$result = array("error" => 1, 'msg' => 'sorry,短信发送失败');
						}else{
							// string(292) "{"result":{"status":"NOK","error":"Account does not exist or has expired.","testmode":false},"content":{"value":"è¿™æ˜¯ä¸€æ¡æµ‹è¯•ä¿¡æ¯ï¼Œè¯·å¿½ç•¥è°¢è°¢","encoding":null,"chars":0,"parts":0},"receivers":[],"credit":{"balance":0,"required":0}}"
							var_dump($res);exit();
							// $result = array("error" => 0, 'msg' => 'Success');
						}

					}else{
						$result = array("error" => 1, 'msg' => '数据库添加错误');
					}

					// if ($this->samplings->insert_reg($user_data)) { 
					// 	$user_info = $this->samplings->user_reg_info($user_data['email']); 
					// 	if (!empty($user_info)) {
					// 		$result = array("error" => 0, 'msg' => 'Success');
					// 	}else{
					// 		log_message('error', 'signup #203: -->' . json_encode($user_data));
					// 		$result = array("error" => 1, 'msg' => 'Failed #203');
					// 	}
					// }else{
					// 	$result = array("error" => 1, 'msg' => 'Failed #202');
					// }
				}else{
					$result = array("error" => 1, 'msg' => 'Thank You For Your Interest!<br><small style="color: white;"> Sorry, we noticed you have already registered for your complimentary kit. </small>');
				}	 
			}else{
				$result = array("error" => 1, 'msg' => 'Failed #201,接收不到数据');
			}
		}
		echo json_encode($result);
	}
	
}
