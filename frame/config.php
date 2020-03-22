<?php
require_once 'Config.class.php';
$conf = new Config();
$conf->root_path = dirname(__FILE__);
$conf->server_name = 'localhost';
$conf->server_url = 'http://'.$conf->server_name;
$conf->app_root = '/frame';
$conf->app_url = $conf->server_url.$conf->app_root;
$conf->action_root = $conf->app_root.'/view/start';
$conf->action_url = $conf->server_url.$conf->action_root;
//Function convert time to polish name format
function localStrftime($format){
	if (isset($format)){
		$data = explode("-", $format);
		$miesiace = array("stycznia", "lutego", "marca","kwietnia","maja","czerwca","lipca","sierpnia","września","października","listopada","grudnia");
		if ($data[0] < 10)
			$data[0] = substr($data[0], 1);
		echo $data[2] . ' ' . $miesiace[$data[1] - 1] . ' ' . $data[0];
	}
} 
function commentTime($format){
	if (isset($format)){
		$time = substr($format,strrpos($format, " "));
		$format = substr($format,0,strrpos($format, " "));
		$data = explode("-", $format);
		$data2 = explode(":", $time);
		$miesiace = array("stycznia", "lutego", "marca","kwietnia","maja","czerwca","lipca","sierpnia","września","października","listopada","grudnia");
		if ($data[0] < 10)
			$data[0] = substr($data[0], 1);
		return $data[2].' '.$miesiace[$data[1] - 1].' '.$data[0].' '.$data2[0].':'.$data2[1];
	}
} 
?>