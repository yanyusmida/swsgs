<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * AMF CI Library
 *
 * Put the 'AMF' folder (unpacked in 'Libraries')
 * 	define("PRODUCTION_SERVER", false);
 */
class Amfci {

    public $gateway;
    public $CI;
   

    public function __construct($amf_services_path=false) {
        $this->CI = &get_instance();
        
        if (!$amf_services_path) {
           $amf_services_path = APPPATH.'libraries/amf_services';
        }

        //require_once(BASEPATH.'libraries/');
        require BASEPATH . "/libraries/amfphp/globals.php";
        require BASEPATH . "/libraries/amfphp/core/amf/app/Gateway.php";
        require BASEPATH . "/libraries/amfphp/cryptlib.php";

        define('AMFSERVICES', $amf_services_path);

        $this->gateway = new Gateway();
        $this->gateway->setCharsetHandler("utf8_decode", "ISO-8859-1", "ISO-8859-1");
        $this->gateway->setLooseMode();
        $this->gateway->setErrorHandling(E_ALL ^ E_NOTICE);
        $this->gateway->setClassMappingsPath(AMFSERVICES . '/vo');
        $this->gateway->setClassPath(AMFSERVICES);

        if (PRODUCTION_SERVER) {
            //Disable profiling, remote tracing, and service browser
            $this->gateway->disableDebug();
        }
    }

    public function service() {
        $this->gateway->service();
    }

}