<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Ignitelab
 *
 * @package		facebook
 * @author		Jerry Yeh
 * @copyright	Copyright (c) 2011, Ignitelab
 * @link		http://www.ignitelab.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------
require_once('facebook/facebook.php');

class Fb extends Facebook {

    private $CI;
    public $fb_uid;
    public $userinfo;
    public $friendinfo;
    public $isFan;

    public function __construct($config=null) {
        $this->CI = &get_instance();
        if ($config == null) {
            $config = array(
                'appId' => $this->CI->config->item('app_id'),
                'secret' => $this->CI->config->item('app_secret'),
                'cookie' => true,
                'oauth' => true
            );
        }
        parent::__construct($config);
        //$this->fb_uid = $this->fblogin();
    }

    public function fblogin() {
        if (!$this->getUser()) {
            //'redirect_uri' => $this->CI->config->item('app_path') . '/auth_callback',
            echo '<script>top.location.href = "' . $this->getLoginUrl(array('fbconnect' => 0, 'canvas' => 1, 'scope' => $this->CI->config->item('app_perm'))) . '";</script>';
            exit;
        } else if (!isset($_REQUEST["signed_request"])) {
            echo '<script>top.location.href = "' . $this->CI->config->item('app_path') . basename($_SERVER["REQUEST_URI"]) . '"</script>';
            exit;
        }
        $this->fb_uid = $this->getUser();
        return $this->fb_uid;
        //<script>top.location.href = "<?=$this->getLoginUrl(array('fbconnect'=>0,'canvas'=>1,'scope'=>APP_PERM))";</script>
    }

    public function get_fbuser_detail() {
        $multiquery = array(
            "query1" => "SELECT uid FROM page_fan WHERE uid=me() AND page_id=" .  $this->CI->config->item('fanpage_id'),
            "query2" => "SELECT name,first_name,last_name,sex,email, birthday_date,interests,music,tv,movies,books,quotes FROM user WHERE uid =" . $this->fb_uid,
            //"query2"=>"SELECT name,sex FROM user WHERE uid =".$user,
            "query3" => "SELECT uid, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1=" . $this->fb_uid . ")"
        );


        $results = $this->api(array(
                    'method' => 'fql.multiquery',
                    'queries' => $multiquery
                ));

        $this->isfan = sizeof($results[0]["fql_result_set"]);
        $this->userinfo = $results[1]["fql_result_set"];
        $this->friendinfo = $results[2]["fql_result_set"];

        $interestAr = null;
        $likeAr = null;


        if ($this->userinfo[0]["interests"] != "") {
            $interestAr = $this->userinfo[0]["interests"];
        }
        if ($this->userinfo[0]["music"] != "") {
            $likeAr .= "music:" . $this->userinfo[0]["music"] . "\r\n";
        }
        if ($this->userinfo[0]["tv"] != "") {
            $likeAr .= "tv:" . $this->userinfo[0]["tv"] . "\r\n";
        }
        if ($this->userinfo[0]["movies"] != "") {
            $likeAr .= "movies:" . $this->userinfo[0]["movies"] . "\r\n";
        }
        if ($this->userinfo[0]["books"] != "") {
            $likeAr .= "books:" . $this->userinfo[0]["books"] . "\r\n";
        }
        if ($this->userinfo[0]["quotes"] != "") {
            $likeAr .= "quotes:" . $this->userinfo[0]["quotes"] . "\r\n";
        }

        $fbdata['fb_uid'] = $this->fb_uid;
        $fbdata['fb_name'] = $this->userinfo[0]["name"];
        $fbdata['fb_firstname'] = $this->userinfo[0]["first_name"];
        $fbdata['fb_lastname'] = $this->userinfo[0]["last_name"];
        $fbdata['fb_gender'] = $this->userinfo[0]["sex"];

        if (isset($this->userinfo[0]["email"])) {
            $fbdata['fb_email'] = $this->userinfo[0]["email"];
        };

        if (isset($this->userinfo[0]["birthday_date"])) {
            $fbdata['fb_birthday_date'] = $this->userinfo[0]["birthday_date"];
        };

        if ($likeAr != null) {
            $fbdata['fb_likes'] = $likeAr;
        };

        if ($interestAr != null) {
            $fbdata['fb_interests'] = $interestAr;
        };

        return $fbdata;
    }

}