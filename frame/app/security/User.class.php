<?php
class User{
	private $login;
	private $id;
	private $type;
	
	public function __construct($login, $id, $type){
		$this->login = $login;
		$this->id = $id;		
		$this->type = $type;		
	}
	private function role($role){
		if ($role == "a") return true;
		else return false;
	}
	public function isUser(){
		return  isset($this->login) && isset($this->id) && isset($this->type);
	}
	public function isAdmin(){
		return  isset($this->login) && isset($this->id) && isset($this->type) && $this->role($this->type) ;
	}
}
