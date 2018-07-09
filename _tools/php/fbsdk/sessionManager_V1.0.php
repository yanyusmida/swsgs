<?php
/**
	Session Manager
	( Session hanling via Database )
	Author: Xerxis Anthony B. Alvar
	
	[ Usage : ]
		- include_once('sessionManager.php');
		- $_SESSION['varname'] = $value;
		- session_write_close()  <<<<<---- Forces the DB to commit changes, so that DB session works
	
	[ Change Logs ]
			[ 01 - 01 - 2012 ] : First Draft
			
			
			
*/

//Database Settings 

// apps14.ignitelab.com
define('SM_DB_USERNAME', 'session_manager');
define('SM_DB_PASSWORD', 'yL6YyxfhvfATTX3v');
define('SM_DB_HOST', 'localhost'); 
define('SM_DB_NAME', 'session_manager');
define('SM_TBL_NAME','session_table');

//error_reporting(E_ALL);

$sm = new DbSessionHandler(SM_DB_HOST, SM_DB_USERNAME, SM_DB_PASSWORD, SM_DB_NAME);
session_set_save_handler(
	array(&$sm, '_open'),
	array(&$sm, '_close'),
	array(&$sm, '_read'),
	array(&$sm, '_write'),
	array(&$sm, '_destroy'),
	array(&$sm, '_clean')
	);
session_start();
//session_regenerate_id(true); // replaces id with fresh one each time

class DbSessionHandler  {

	private $con = NULL;

	private $DbHost = '';

	private $DbUser = '';

	private $DbPwd = '';

	private $DbName = '';
	
	function __construct($db_host, $db_user, $db_pass, $db_name) {
	
			$this->DbHost = $db_host;

			$this->DbUser = $db_user;

			$this->DbPwd = $db_pass;

			$this->DbName = $db_name;
	}

	public function _open() {

		$this->con = mysql_connect($this->DbHost, $this->DbUser, $this->DbPwd);

		if ($this->con) { 	return mysql_select_db($this->DbName, $this->con); }

		return FALSE;

	}

	public function _close() {

		return mysql_close($this->con);

	}

	public function _read($id)  {

		$id = mysql_real_escape_string($id);

		$sql = "SELECT data FROM ".SM_TBL_NAME." WHERE id = '$id'";

		$result = mysql_query($sql, $this->con);

		if ($result) {

			if (mysql_num_rows($result)) {

				$record = mysql_fetch_assoc($result);

				return $record['data'];

			}
		}
		
	}

	public function _write($id, $data)  {

			$access = date('Y-m-d H:i:s');

			$id = mysql_real_escape_string($id);

			$access = mysql_real_escape_string($access);

			$data = mysql_real_escape_string($data);

			$sql = "REPLACE INTO ".SM_TBL_NAME." VALUES ('$id', '$access', '$data')";

			return mysql_query($sql, $this->con);

	}

	public function _destroy($id) {

			$id = mysql_real_escape_string($id);

			$sql = "DELETE FROM ".SM_TBL_NAME." WHERE id = '$id'";

			return mysql_query($sql, $this->con);

	}

	public function _clean($max)  {

		$old = time() - $max;

		$old = mysql_real_escape_string($old);

		$sql = "DELETE FROM ".SM_TBL_NAME." WHERE access < '$old'";

		return mysql_query($sql, $this->con);

	}

}//END : DbSessionHandler



?>