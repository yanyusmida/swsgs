<?php
/**
	Cleans input tags for any malicious script tags
*/
$_ORIG_REQUEST = array();
$_ORIG_POST = array();
$_ORIG_GET = array();

function __cleanInput($externalInput) {
	return strip_tags($externalInput);
}

function __cleanAndCopy(&$input, &$output) {
	foreach($input as $key => $value) {
		$output[$key] = $value;
		$input[$key] = __cleanInput($value);		
	}
}

__cleanAndCopy($_REQUEST , $_ORIG_REQUEST);
__cleanAndCopy($_POST    , $_ORIG_POST   );
__cleanAndCopy($_GET     , $_ORIG_GET    );
?>
