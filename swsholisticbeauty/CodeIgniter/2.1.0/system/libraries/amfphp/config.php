<?php
//configuration file
//SERVER RELATED
error_reporting(E_ALL);
define("DIRECTORY_NAME","microsoftjp");
define("SERVER_PATH","http://".$_SERVER["HTTP_HOST"]."/".DIRECTORY_NAME."/");
define("LIBPATH", $_SERVER["DOCUMENT_ROOT"]."/");
define('ABSPATH', $_SERVER["DOCUMENT_ROOT"]."/".DIRECTORY_NAME."/");
//define('BASCE_REST_API','http://dbs3.esdlife.com/rest/rest.php');  //production
//define('BASCE_REST_API','http://apps.ignitelab.com/dbs_hk/rest.php');	//staging
//define('BASCE_REST_API_TOKEN','basce');
//define('PHOTO_THUMBNAIL_WEB_PATH',SERVER_PATH."photo/117/");
//define('PHOTO_BIG_WEB_PATH',SERVER_PATH."photo/424/");
//define('PHOTO_RAW_WEB_PATH',SERVER_PATH."photo/720/");
define('EXTRA_PARTICULAR','name,age,phone_number,email,ic,guardian_name, guardian_contact');

//date_default_timezone_set('Asia/Hong_Kong');
require_once(LIBPATH.'_tools/_lib/adodb5/adodb.inc.php');			
require_once(LIBPATH.'_tools/_lib/adodb5/adodb-exceptions.inc.php'); 	
require_once(LIBPATH.'_tools/_lib/facebook/v2_1_2/facebook.php');

//facebook key and secret
define("APP_ID","158183157574317");
define("APP_KEY","90207b56af1c77176cf6756c12d4edb7");
define("APP_SECRET","e7c776fd00041b5623dba740a31f1c72");
define("FB_PATH", "http://apps.facebook.com/microsoftmg/");
define("APP_PERM","publish_stream,email,user_birthday,user_interests,user_likes");
define("APP_NAME", "Xbox 360 Challenge  !!");
define("GOOGLE_ANALYTIC","");					

define("FANPAGE_ID","200610979972591");  		
define("FANPAGE_URL","http://www.facebook.com/pages/Gm20110407/200610979972591");
define("FANPAGE_NAME","Game");
define("FANPAGE_TITLE","same");				
define("PAGE_TITLE",APP_NAME);

//fan page tab
$fanpage_tab = array();
$fanpage_tab[] = array("name"=>"Wall","url"=>FANPAGE_URL . "?v=wall");
$fanpage_tab[] = array("name"=>"Info","url"=>FANPAGE_URL . "?v=info");
$fanpage_tab[] = array("name"=>FANPAGE_TITLE,"url"=>FANPAGE_URL . "?v=".APP_ID);

//database
define('DBHOST','localhost');
define('DBUSERNAME','web7u1');
define('DBPASSWORD','y246XG+');
define('DBNAME','web7db1');
define("DB_DRIVER", "mysqli://".DBUSERNAME.":".DBPASSWORD."@".DBHOST."/".DBNAME);

//database table name

/**
microsoftjp_gm_admin
 microsoftjp_gm_config
 microsoftjp_gm_entries
 microsoftjp_gm_timezone
 microsoftjp_gm_tracelog
 microsoftjp_gm_users
 microsoftjp_gm_votes
 microsoftjp_gm_winners
*/
define('DB_USER', 'microsoftjp_gm_users');
define('DB_ADMIN', 'microsoftjp_gm_admin');
define('DB_CONFIG', 'microsoftjp_gm_config');
define('DB_ENTRY', 'microsoftjp_gm_entries');
define('DB_TIMEZONE', 'microsoftjp_gm_timezone');
define('DB_TRACELOG', 'microsoftjp_gm_tracelog');
define('DB_VOTE', 'microsoftjp_gm_votes');
define('DB_WINNER', 'microsoftjp_gm_winners');

?>