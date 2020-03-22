<?php
require_once $conf->root_path.'/lib/medoo.min.php';

class DatabaseCtrl{
	private $db;		
	public function __construct(){
		$this->db = new medoo(array(
			'database_type' => 'mysql',
			'database_name' => 'edziennik',
			'server' => 'localhost',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		));
	}	
	public function connector(){
		return $this->db;
	}
	//var_dump($this->db->error());		
	
}
