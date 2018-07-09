<?php
/**
	Facebook Graph API Utils
	Ignite Lab
	Author : Xerxis Anthony B. Alvar	
*/


if (!function_exists('curl_init')) {
  echo 'IgLabs needs the CURL PHP extension.';
  throw new Exception('IgLabs needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  echo 'IgLabs needs the JSON PHP extension.';
  throw new Exception('IgLabs needs the JSON PHP extension.');
}

abstract class iglabFbUtils {
	

	public $app_id = null;
	public $app_secret = null;
	public $signed_request = null;
	
	
	function __construct($config) {
		$this->set_app_id($config['APP_ID']);
		$this->set_app_secret($config['APP_SECRET']);
	}
	
	
	/*
	 *  Check user is a Fan of Fan Page 
	 */
	public function isFan($user_fbid = null,$fanPageId = null) {
			$fql = "SELECT uid FROM page_fan WHERE uid=".$user_fbid." AND page_id=".$fanPageId;
			$d = $this->single_fql($fql);	
			return (empty($d)) ? false : true;
			
	}	
	
	
	// Get Facebook Id of currently Logged User
	public function get_user_id() {
		if (!empty($this->signed_request['user_id'])) 	return $this->signed_request['user_id'];   

		if (!isset($_SESSION))  session_start();			
		if (isset($_SESSION['user_id'])) {
			return $_SESSION['user_id'];
		} else {
			return false;
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
		  	}// else {
			//	throw new Exception("Can not find Signed Request anywhere");
			//}
	  	  }
		}	
		return $this->signed_request;
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
	
	
	
	/**
		Get User Access Token
	*/
	public function get_user_access_token($signedRequest) {
		//for Tab
		if (array_key_exists('oauth_token', $signedRequest)) {
			return $signedRequest['oauth_token'];
		} 
	
		//get it from the session
		if (!isset($_SESSION)) session_start();
		if ($_SESSION['access_token'])  {
			return $_SESSION['access_token'];
		} else {
			return false;
		}
	}
	
	
	
	//---------- [ FQL via GRAPH ] ------------------------------
	
	/**
		Run single FQL Query
		ex: 
				$fql = "select uid,name,email,interests from user where uid=me()";
				$d = $fb->single_fql($fql);
	*/
	public function single_fql($sql) {
		$sr = $this->get_signed_request();
		$accessToken = $this->get_user_access_token($sr);
		if ($accessToken != false) {
			$fql = str_replace( " ", "+", $sql);
			$fql_query_url = 'https://graph.facebook.com/fql?q='.$fql. '&access_token=' . $accessToken;
			$res = $this->doCurl($fql_query_url,array());
			if (!$res['errno']) {
				$data = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $res['content']), true);
				
				return (count($data['data'])) ? $data['data'][0] : array();
			} else {
				return json_decode(array('errmsg' => $res['errmsg']));
			}
		} else {
			throw new Exception('User access token not found');
		}
	}
	
	
	
	/**
		Run Multiple FQL Query
		@$sqlarray = array of FQL statements
	*/
	public function multiple_fql($sqlarray) {
		$sr = $this->get_signed_request();
		$accessToken = $this->get_user_access_token($sr);
		if ($accessToken != false) {
			//fix fql
			$fqlArr = array(); 
			$i = 1;
			foreach($sqlarray as $k => $v) {
				$fqlArr[] =   '"'.$k.'":"'.str_replace( " ", "+", $v).'"';
				$i++;
			}
			$flqStr = '{' . join(",",$fqlArr).'}';
			
			$fql_query_url = 'https://graph.facebook.com/fql?q='.$flqStr. '&access_token=' . $accessToken;
			$res = $this->doCurl($fql_query_url,array());
			
			if (!$res['errno']) {
				$data = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $res['content']), true);
				return $data['data'];
			} else {
				return json_decode(array('errmsg' => $res['errmsg']));
			}		
		
		} else {
			throw new Exception('User access token not found');
		}
	}
	
	
	
	/*
		Get Basic information of the current User ( depends on the permission granted
	*/
	public function	get_me() {
		$sr = $this->get_signed_request();
		$accessToken = $this->get_user_access_token($sr);
		$url = 'https://graph.facebook.com/me?access_token='.$accessToken;
			$res = $this->doCurl($url,array());
			if (!$res['errno']) {
				$data = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $res['content']), true);
				return $data;
			} else {
				return json_decode(array('errmsg' => $res['errmsg']));
			}
	}

	
	
	
	//---------- [ APP FUNCTIONS ] ------------------------------
	
	/*
	 *   Check if user has already added the application
	 */
	public function isAppUser() {
		$app = $this->get_signed_request();
		return (isset($app['user_id'])) ? true : false;
	}
	
	
	/**
		Get the current URL
		
	*/
	public function get_current_url() {
	    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )  ? 'https://' : 'http://';
		return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
	
	public function authorize_app($nextUrl,$perms) {
		if (!$this->isAppUser()) {		
			$oauthUrl = "http://www.facebook.com/dialog/oauth/?"
		  			  ."scope=".$perms
		  			  ."&client_id=".$this->get_app_id()
		  			  ."&redirect_uri=".$nextUrl
		  			  ."&response_type=code";	 
			echo '<script type="text/javascript">top.location.href="'.$oauthUrl.'";</script>';
			exit();
		}
	}	
	
	//---------- [ TAB FUNCTIONS ] ------------------------------
	public function isFaninTab($signrequest){
		return ( isset($signrequest["page"]["liked"])  && $signrequest["page"]["liked"] == 1  ) ? 1 : 0;
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
	
}

?>