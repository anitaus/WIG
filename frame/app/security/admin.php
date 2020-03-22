<?php
require_once $conf->root_path.'/app/security/User.class.php';
if(!isset($_SESSION)){
    session_start();	
}
if (isset($_SESSION['user'])){
	$user = new User($_SESSION['user'],$_SESSION['user_id'],$_SESSION['type']);
	if (! $user->isAdmin()){
		include_once $conf->root_path.'/app/security/LoginCtrl.class.php';
		$ctrl = new LoginCtrl();
		$ctrl->redirect();
	}
}
else{
	include_once $conf->root_path.'/app/security/LoginCtrl.class.php';
	$ctrl = new LoginCtrl();
	$ctrl->redirect();
}



