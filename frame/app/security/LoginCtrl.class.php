<?php
if (!isset($_SESSION)){
	session_start();
}	
require_once dirname(__FILE__).'/../../config.php';
require_once $conf->root_path.'/app/security/User.class.php';

class LoginCtrl{
	private $login;
	private $pass;
	private $db;
	public function __construct(){
		$this->db = new DatabaseCtrl();
	}
	public function getParams(){
		if (! (isset ( $_POST['pass'] ))){
			echo '[LoginCtrl] Runtime error';
			exit();
		}
		$this->login = $_POST ['login'];
		$this->pass = $_POST ['pass'];
	}	
	public function validate() {
		$this->getParams();
		if (! (isset ( $this->login ) && isset ( $this->pass ))) {
			echo "Runtime error";
			exit();
		}
		$datas = $this->db->connector()->select("nauczyciele", [
								"imie",
								"nazwisko",
								"email",
								"typ",
								"id_nauczyciel",
							], [
								"AND" => [
									"email" => $this->login,
									"haslo" => sha1($this->pass),
								]
							]);
		if( $datas){
			foreach($datas as $data){
				$user = new User($data["email"], $data['id_nauczyciel'], $data['typ']);
				if ($data['typ'] == 'a'){
					$_SESSION['admin'] = 'true';	
				}
				else{
					$_SESSION['admin'] = 'false';	
				}					
				$_SESSION['type'] = $data['typ'];
				$_SESSION['user'] = $data['email'];
				$_SESSION['name'] = $data['imie'];
				$_SESSION['surname'] = $data['nazwisko'];
				$_SESSION['id']   = $data['id_nauczyciel'];
				$datas[0]['status'] = "ok";
			}
			echo json_encode($datas);
		}
		else{
			$datas[0]['status'] = "err";
			echo json_encode($datas);
		}
	}	
	public function doLogin(){
		global $conf;
		$this->getParams();
		$this->validate();
	}
	public function doLogout(){
		session_destroy();
		$this->redirect();		 
	}
	public function showLogout(){
		global $conf;
		header("Location: ".$conf->app_url."/view/all");
	}
	public function redirect(){
		global $conf;
		include $conf->root_path.'/view/'.'show_account.php';
		exit();
	}
}

