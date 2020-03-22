<?php
require_once dirname(__FILE__).'/../database/DatabaseCtrl.class.php';
class InstallCtrl {	
	public $db;
		
	public function __construct(){
		$this->db = new DatabaseCtrl();
	}	
	public function install(){
		$query = $this->db->connector()->pdo->prepare('CREATE TABLE IF NOT EXISTS `cat` ( `cat_id` INT NOT NULL AUTO_INCREMENT , `cat_name` VARCHAR (40) NOT NULL , PRIMARY KEY (`cat_id`)) ENGINE = InnoDB; DEFAULT CHARSET=latin1 ;');
		$query->execute();
		$query = $this->db->connector()->pdo->prepare('CREATE TABLE IF NOT EXISTS `comm` (`comm_id` int(11) NOT NULL AUTO_INCREMENT, `comm_author` varchar(40) NOT NULL, `comm_date` date NOT NULL, `comm_msg` varchar(200) NOT NULL, PRIMARY KEY (`comm_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');
		$query->execute();
		$query = $this->db->connector()->pdo->prepare('CREATE TABLE IF NOT EXISTS `users` (`user_id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(40) NOT NULL, `name` varchar(40) NOT NULL, `surname` varchar(40) NOT NULL, `pass` varchar(40) NOT NULL, `type` varchar(1) NOT NULL, PRIMARY KEY (`user_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');
		$query->execute();
		$query = $this->db->connector()->pdo->prepare('CREATE TABLE IF NOT EXISTS `msg` ( `msg_id` INT NOT NULL AUTO_INCREMENT , `msg_user_id` INT NOT NULL , `msg_title` VARCHAR(50) NOT NULL , `msg_date` DATE NOT NULL , `msg` VARCHAR(200) NOT NULL , PRIMARY KEY (`msg_id`)) ENGINE = InnoDB; DEFAULT CHARSET=latin1 ; ');
		$query->execute();
		$query = $this->db->connector()->pdo->prepare('ALTER TABLE `framework`.`msg` ADD INDEX(`msg_user_id`);');
		$query->execute();
		$query = $this->db->connector()->pdo->prepare('ALTER TABLE `framework`.`msg` ADD CONSTRAINT `relacja` FOREIGN KEY (`msg_user_id`) REFERENCES `framework`.`users`(`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION');
		$query->execute();			
		$count = $this->db->connector()->count("comm", []);
		if ($count < 3){
			$this->db->connector()->insert("cat", [
				"cat_name" => 'Kategoria 1'
			]);
			$this->db->connector()->insert("cat", [
				"cat_name" => 'Kategoria 2'
			]);
			$this->db->connector()->insert("cat", [
				"cat_name" => 'Kategoria 3'
			]);
			$this->db->connector()->insert("comm", [
				"comm_msg" => 'To jest test wiadomosci',
				"comm_author" => 'Agata',
				"comm_date" => '15-10-20'
			]);
			$this->db->connector()->insert("comm", [
				"comm_msg" => 'To jest test wiadomosci',
				"comm_author" => 'Kasia',
				"comm_date" => date('Y-m-d')
			]);
			$this->db->connector()->insert("comm", [
				"comm_msg" => 'To jest test wiadomosci',
				"comm_author" => 'Agnieszka',
				"comm_date" => '15-10-10'
			]);
			$this->db->connector()->insert("users", [
				"email" => 'admin@projekt.pl',
				"name" => 'Jan',
				"surname" => 'Kowalski',
				"pass" => 'd033e22ae348aeb5660fc2140aec35850c4da997',
				"type" => 'a'
			]);
			$this->db->connector()->insert("users", [
				"email" => 'b@b.pl',
				"name" => 'Monika',
				"surname" => 'Nowak',
				"pass" => '78dc0cd3e7ef475d2c3e664078e5f1d7b3b719ab',
				"type" => 'u'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => 'Hello World',
				"msg_date" => '2015-11-10',
				"msg" => "If you see this page it means that the framework has been configured correctly and was able to connect with database. Now you're a conductor and you can create your first symphonies."
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '1',
				"msg_date" => '2015-11-10',
				"msg" => '1'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '2',
				"msg_date" => '2015-11-10',
				"msg" => '2'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '3',
				"msg_date" => '2015-11-10',
				"msg" => '3'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '4',
				"msg_date" => '2015-11-10',
				"msg" => '4'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '5',
				"msg_date" => '2015-11-10',
				"msg" => '5'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '6',
				"msg_date" => '2015-11-10',
				"msg" => '6'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '7',
				"msg_date" => '2015-11-10',
				"msg" => '7'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '8',
				"msg_date" => '2015-11-10',
				"msg" => '8'
			]);
			$this->db->connector()->insert("msg", [
				"msg_user_id" => '1',
				"msg_title" => '9',
				"msg_date" => '2015-11-10',
				"msg" => '9'
			]);
			$header = "Congratulations!";
			$txt = "Installing the framework has been completed successfully. All modules sounds great.";
		}
		else{
			$header = "Holy moly!";
			$txt = "Framework has already been installed.";
		}
		global $conf;
		include $conf->root_path.'/view/'.'show_install.php';	
	}	
}
