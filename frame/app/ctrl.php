<?php
require_once dirname (__FILE__).'/../config.php';
require_once $conf->root_path.'/app/security/LoginCtrl.class.php';
require_once $conf->root_path.'/app/database/DatabaseCtrl.class.php';

// Split address to $_GET params format: $params[0], $params[1] etc.
$request = str_replace($conf->app_root."/", "", $_SERVER['REQUEST_URI']);
$params = mb_split("/", $request);
//Installation script
if ($params[0] == "install"){
	if ( isset($params[1]) && ($params[1] == "framework") ) {
		global $conf;
		include_once $conf->root_path.'/app/install/InstallCtrl.class.php';
		$ctrl = new InstallCtrl();
		$ctrl->install();
	}
}
// Login routing
if ($params[0] == "account"){
	$ctrl = new LoginCtrl();
	$ctrl->redirect();
}
if ($params[0] == "login"){
	$ctrl = new LoginCtrl();
	$ctrl->doLogin();
}
if ($params[0] == "logout"){
	$ctrl = new LoginCtrl();
	$ctrl->doLogout();
}
// View routing
if ($params[0] == "view"){
	if ($params[1] == "start"){
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->showStart();
	}
	else if ($params[1] == "ajax"){
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->showAJAX();
	}
	// /view/5 lub /view/5/
	else if ( (isset($params[1]) && is_numeric($params[1]) && !isset($params[2]))  ||  
	     (isset($params[1]) && is_numeric($params[1]) && (isset($params[2]))  &&  ($params[2] == ''))){
			include $conf->root_path.'/app/security/user.php';
			include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
			$ctrl = new ShowCtrl($params[1]);
			$ctrl->showOne($params[1]);
	}
	// /view/all lub /view/all/
	else if ( (isset($params[1]) && ($params[1]=="all") && !isset($params[2])) ||  
	     (isset($params[1]) && ($params[1]=="all") && (isset($params[2]))  && ($params[2] == ''))){
				include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
				$ctrl = new ShowCtrl(null);
				$ctrl->showAll();
	}
	// view/przedmioty
	else if ( (isset($params[1]) && ($params[1]=="przedmioty") && !isset($params[2])) ||  
	     (isset($params[1]) && ($params[1]=="przedmioty") && (isset($params[2]))  && ($params[2] == ''))){
			include $conf->root_path.'/app/security/user.php';
			include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
			$ctrl = new ShowCtrl(null);
			$ctrl->showPrzedmioty();
	}
	else if ( (isset($params[1]) && ($params[1]=="oceny") && !isset($params[2])) ||  
	(isset($params[1]) && ($params[1]=="oceny") && (isset($params[2]))  && ($params[2] == ''))){
	   include $conf->root_path.'/app/security/user.php';
	   include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
	   $ctrl = new ShowCtrl(null);
	   $ctrl->showOceny();
}
	
	else{
		echo 'runtime error';
	}	
}
// AJAX requests
if ($params[0] == "get"){
	if ( isset($params[1]) && ($params[1] == "categories") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getCat();
	}
	if ( isset($params[1]) && ($params[1] == "msg") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getMsg();
	}
	if ( isset($params[1]) && ($params[1] == "demo") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getDemo();

	}
	if ( isset($params[1]) && ($params[1] == "kursy") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getKursy();

	}
	if ( isset($params[1]) && ($params[1] == "uczniowie") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getUczniowie();

	}
	if ( isset($params[1]) && ($params[1] == "zajecia") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getZajecia();

	}
	if ( isset($params[1]) && ($params[1] == "jednezajecia") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getJedneZajecia();

	}
	if ( isset($params[1]) && ($params[1] == "obecnosc") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getObecnosc();

	}
	if ( isset($params[1]) && ($params[1] == "oceny") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getOceny();

	}
	if ( isset($params[1]) && ($params[1] == "ocenyAll") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->getOcenyWszystkie();

	}
}
if ($params[0] == "set"){
	if ( isset($params[1]) && ($params[1] == "msg") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->setMsg();
	}
	if ( isset($params[1]) && ($params[1] == "kurs") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->setKurs();
	}
	if ( isset($params[1]) && ($params[1] == "uczen") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->setUczen();
	}
	if ( isset($params[1]) && ($params[1] == "obecnosc") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->setObecnosc();
	}
	if ( isset($params[1]) && ($params[1] == "ocena") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->setOcena();
	}
}
if ($params[0] == "del"){
	if ( isset($params[1]) && ($params[1] == "msg") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl();
		$ctrl->delMsg();
	}
	if ( isset($params[1]) && ($params[1] == "ocena") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->delOcena();
	}
}
if ($params[0] == "update"){
	if ( isset($params[1]) && ($params[1] == "ocena") ) {
		global $conf;
		include_once $conf->root_path.'/app/show/ShowCtrl.class.php';
		$ctrl = new ShowCtrl(null);
		$ctrl->updateOcena();
	}
}
?>
