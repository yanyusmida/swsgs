<?php
/**
	Facebook Graph API Utils
	Ignite Lab
	Author : Xerxis Anthony B. Alvar	
*/

abstract class iglabFbUtils {
	

	public $app_id = null;
	public $app_secret = null;
	public $signed_request = null;
	
	
	function __construct($config) {
		$this->set_app_id($config['APP_ID']);
		$this->set_app_secret($config['APP_SECRET']);
	}
	
	
	// Get Facebook Id of currently Logged User
	public function get_user_id() {
		if (!empty($this->signed_request)) {
			return $this->signed_request['user_id'];   
	    } else {
			if (!isset($_SESSION))  session_start();			
			return $_SESSION['user_id'];
		}
	}
	
	
	// Get Facebook Name of currently logged user
	public function get_user_name($fbid) {
		return json_decode(file_get_contents("https://graph.facebook.com/{$fbid}"))->name;
	
	}
	
	
	public function get_signed_request() {
		if (!$this->signed_request) {
		  //find in $_REQUEST
		  if (isset($_REQUEST['signed_request'])) {
			$this->signed_request = $this->parseSignedRequest($_REQUEST['signed_request']);
		  
		  //find in $_COOKIE
		  } elseif(isset($_COOKIE['fbsr_'.$this->get_app_id()])) {
			$this->signed_request = $this->parseSignedRequest($_COOKIE['fbsr_'.$this->get_app_id()]);
		  
		  //find it in $_SESSION
		  } else {
			if(!isset($_SESSION)) session_start();
			if (isset($_SESSION['signed_request'])) {
				$this->signed_request = $this->parseSignedRequest($_SESSION['signed_request']);
		  	} else {
				throw new Exception("Can not find Signed Request anywhere");
			}
	  	  }
		}	
		return $this->signed_request;
	}
	
	
  protected function parseSignedRequest($signed_request) {
	list($encoded_sig, $payload) = explode('.', $signed_request, 2);

	// decode the data
	$sig = $this->base64UrlDecode($encoded_sig);
	$data = json_decode($this->base64UrlDecode($payload), true);

	if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
	  throw new Exception('Unknown algorithm. Expected HMAC-SHA256');
	  return null;
	}

	// check sig
	$expected_sig = hash_hmac('sha256', $payload,
							  $this->get_app_secret(), $raw = true);
	if ($sig !== $expected_sig) {
	  throw new Exception('Bad Signed JSON signature!');
	  return null;
	}

	return $data;
  }

	protected static function base64UrlDecode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}
  
	
	//Set Application Secret
	public function set_app_secret($appSec) {
		if (empty($appSec)) {
			throw new Exception("Application Secret is Null");
		} else {
			$this->app_secret = $appSec;
		}	
	}
	
	//Get currently set application Secret
	public function get_app_secret() {
		if (!empty($this->app_secret)) {	
			return $this->app_secret;
		} else {
			 throw new Exception('Application secret is Missing');
		}
	}
	
	//Set Application Id
	public function set_app_id($appId) {
		if (empty($appId)) {
			throw new Exception("Application ID is Null");
		} else {
			$this->app_id = $appId;
		}	
	}
	
	//Get currently set application ID
	public function get_app_id() {
		if (!empty($this->app_id)) {	
			return $this->app_id;
		} else {
			 throw new Exception('Application ID Missing');
		}
	}
	
	
	
	
	/*
	 *  Get Application Access Token
	 */
	public function getAppAccessToken($appId = null ,$appSecret = null) {
		$appId = (isset($appId)) ? $appId :  $this->CONFIG['APP_ID']; 	
		$appSecret = (isset($appSecret)) ? $appSecret : $this->CONFIG['APP_SECRET'];
		
		$params = array(
			'client_id'		  => $appId , 
			'client_secret' => $appSecret,
			'grant_type' 	  => 'client_credentials'
		);
		$url = 'https://graph.facebook.com/oauth/access_token';		
		$result = $this->doCurl($url,$params);		
		$data = explode("=",$result['content']);
		return $data[1];				
	}

	/*
	 *  Get Page Access Token
			@$pageId : Fan Page Id / Fan Page username
	 */
	public function getPageAccessToken($pageId) {
		$url = 'https://graph.facebook.com/'.$pageId.'?fields=access_token&access_token=' . $this->CONFIG['ACCESS_TOKEN'];	
		$params = array();			
		$result = $this->doCurl($url,$params);		
		$data = json_decode($result['content']);
		if (isset($data->access_token)) {
			return $data->access_token;
		} else {
			return false;
		}
	}
	
	
	/**
	   Get Admin Pages
	*/
	public function getAdminPages() {
		$url = 'https://graph.facebook.com/me/accounts?access_token=' . $this->CONFIG['ACCESS_TOKEN'];
		$params = array();			
		$result = $this->doCurl($url,$params);		
		$data = json_decode($result['content'])->data;
		$arr = array(); $i=0;
		foreach($data as $d) {
			if ($d->category != 'Application') {
				$arr[$i] = $d; 
				$i++;
			}
		}
		return $arr;		
	}

	/**
		Install an application to a Fan Page
	*/
	public function installAppToPage($appId,$pageId) {
		$pageAccessToken = $this->getPageAccessToken($pageId);
		
		if (!$pageAccessToken) return false;
		
		$url = 'https://graph.facebook.com/'.$pageId.'/tabs?app_id='.$appId
					.'&is_permanent=0&method=POST&access_token='.$pageAccessToken;
		
		$params = array();			
		$result = $this->doCurl($url,$params);		
		$data = $result['content'];
		
		$this->showArray($data);
	}
	
	
	/**
		Get page information ( no access token required )
	*/
	public function get_page_info() {
		$sr = $this->get_signed_request();
		$pageId = $sr['page']['id'];
		$url = 'https://graph.facebook.com/'. $pageId;
		$params = array();			
		$result = $this->doCurl($url,$params);		
		$data = json_decode($result['content']);
		return $data;
	}
	
	/**
		Get Application information ( no access token required )
	*/
	public function get_app_info() {
		$sr = $this->get_signed_request();
		$url = 'https://graph.facebook.com/'. $this->get_app_id();
		$params = array();			
		$result = $this->doCurl($url,$params);		
		$data = json_decode($result['content']);
		return $data;
	}
	
	

	
	/*
		Debug Tool
	*/
	
	public function showArray($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	
	
	/**
 * Default options for curl.
 * Made it public if there are cases that needs to add more option in curl
 */
	public $CURL_OPTS = array(      
		CURLOPT_RETURNTRANSFER =>true,
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => false,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle all encodings
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 10,      // timeout on connect
		CURLOPT_TIMEOUT        => 60,      // timeout on response
		CURLOPT_MAXREDIRS      => 3,       // stop after 10 redirects
		CURLOPT_SSL_VERIFYPEER => false
  );	    

      
	/** 
	 * PHP CURL
	 * @url = target URL
	 * @params = POST Parameters (optional)
	 * @$supportFileUpload = Flag if using curl for file upload default to False
	 * @ch = initialize curl handler
	 */
	protected  function doCurl($url,$params = null,$supportFileUpload = FALSE, $ch = null) {

		if (!$ch) $ch = curl_init();
		

		//apply CURL options
		$options = $this->CURL_OPTS;
				 
		if (!empty($params)) {
			if ($supportFileUpload === true) {
					//base on http://php.net/manual/en/function.curl-setopt.php
					//If value is an array, the Content-Type header will be set to multipart/form-data. 
					//As of PHP 5.2.0, files thats passed to this option with the @ prefix must be in array form to work.
					$options[CURLOPT_POST] = true;
					$options[CURLOPT_POSTFIELDS] = $params;
			} else {
					//base on https://github.com/facebook/php-sdk/issues/172
					//convert post params to get params
					$options[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');    		   	
			}
		}
		$options[CURLOPT_URL] = $url;
		
		 //from Naitik
		 // disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
		 // for 2 seconds if the server does not support this header.
		if (isset($options[CURLOPT_HTTPHEADER])) {
			$existing_headers = $options[CURLOPT_HTTPHEADER];
			$existing_headers[] = 'Expect:';
			$options[CURLOPT_HTTPHEADER] = $existing_headers;
		} else {
			$options[CURLOPT_HTTPHEADER] = array('Expect:');
		}    	
		
		curl_setopt_array( $ch, $options );   	    	
		$result['errno']   = curl_errno( $ch );
		$result['errmsg']  = curl_error( $ch );
		$result['content'] = curl_exec( $ch );
		curl_close( $ch );	    	  
		return $result;
	}		    
	
	
	

	protected function parse_signed_request($signed_request, $secret) {
	  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

	  // decode the data
	  $sig = $this->base64_url_decode($encoded_sig);
	  $data = json_decode($this->base64_url_decode($payload), true);

	  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
		error_log('Unknown algorithm. Expected HMAC-SHA256');
		return null;
	  }

	  // check sig
	  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
	  if ($sig !== $expected_sig) {
		error_log('Bad Signed JSON signature!');
		return null;
	  }

	  return $data;
	}

	private function base64_url_decode($input) {
	  return base64_decode(strtr($input, '-_', '+/'));
	}	
	
}

?>