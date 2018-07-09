<?php
//------------------------------------------------------------------------------------

	//This file is intentionally left blank so that you can add your own global settings
	//and includes which you may need inside your services. This is generally considered bad
	//practice, but it may be the only reasonable choice if you want to integrate with
	//frameworks that expect to be included as globals, for example TextPattern or WordPress

	//Set start time before loading framework
	
	function changetimelegal($time){
	$newtime = intval($time /1000);
	$senterseconds = intval(($time %1000)/10);
	$mins = intval($newtime/60);
	$secs = intval($newtime%60);
	return addZero($mins).":".addZero($secs).":".addZero($senterseconds);
}

function addZero($num){
	if($num == 0){
		return "00";
	}else if($num >= 10){
		return $num;
	}else{
		return "0".$num;
	}
}

function getSwapPosition($pos){
	//get left
	$v = 0;
	if($pos == 0 || $pos == 3 || $pos == 6){
		$v = 1;
	}else if($pos == 1 || $pos == 4 || $pos == 7){
		$v = rand(0,1)?-1:1;
	}else{
		$v = -1;
	}
	
	$h = 0;
	if($pos == 0 || $pos == 1 || $pos == 2){
		$h = 3;
	}else if($pos == 3 || $pos == 4 || $pos == 5){
		$h = rand(0,1)?-3:3;
	}else{
		$h = -3;
	}
	
	return rand(0,1)?$pos+$v:$pos+$h;
}		

function swap(&$ar){
	//getpossition of empty slot
	$eslot = array_search(0,$ar);
	//find next place to move
	$sslot = getSwapPosition($eslot);
	$tempholder = $ar[$sslot];
	$ar[$sslot] = 0;
	$ar[$eslot] = $tempholder;
}

	list($usec, $sec) = explode(" ", microtime());
	$amfphp['startTime'] = ((float)$usec + (float)$sec);
	
	$servicesPath = "services/";
	$voPath = "services/vo/";

?>