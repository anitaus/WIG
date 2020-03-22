<?php
class ShowCtrl {	
	public $db;
	private $number;
	public function __construct($number){
		$this->db = new DatabaseCtrl();
		$this->number = $number;
	}
	public function showAJAX(){
		global $conf;
		include $conf->root_path.'/view/'.'show_AJAX.php';	
	}
	public function showStart(){
		global $conf;
		include $conf->root_path.'/view/'.'show_przedmioty.php';	
	}
	public function getCat(){
		$datas = $this->db->connector()->select("cat", [
			"cat_name",
			"cat_id"
		]);
		echo json_encode($datas);
	}	
	public function getMsg(){
		$datas = $this->db->connector()->select("comm", [
			"comm_msg",
			"comm_date",
			"comm_id",
			"comm_author"],[
			"ORDER" => "comm_id DESC"
		]);
		echo json_encode($datas);
	}
	public function delMsg(){
		$datas = $this->db->connector()->delete("comm", [
			"comm_id" => $_POST['id']
		]);	
		echo json_encode('ok');
	}	
	public function setMsg(){
		$datas = $this->db->connector()->insert("msg", [
			"comm_msg" => $_POST['msg'],
			"comm_author" => $_POST['nick'],
			"comm_date" => date('Y-m-d')
		]);
		echo json_encode($datas);
	}
	public function showAll(){
		global $conf;
		$datas = $this->db->connector()->select("msg", [
			"[>]users" => ["msg_user_id" => "user_id"]
			], [
			"msg.msg",
			"msg.msg_id",
			"msg.msg_title",
			"msg.msg_date",
			"users.name"
		], [
			"ORDER" => "msg.msg_id ASC"
		]);			
		//var_dump($this->db->connector()->error());			
		//echo json_encode($datas);
		//exit();
		include $conf->root_path.'/view/'.'show_articles.php';
	}
	public function showPrzedmioty(){
		global $conf;
		$datas = $this->db->connector()->select("przedmioty", [	
			"id_przedmiot",
			"nazwa"
		]);	
		//var_dump($this->db->connector()->error());			
		//echo json_encode($datas);
		//exit();
		include $conf->root_path.'/view/'.'show_przedmioty.php';
	}
	public function showOceny(){
		global $conf;
		$datas = $this->db->connector()->select("przedmioty", [	
			"id_przedmiot",
			"nazwa"
		]);	
		//var_dump($this->db->connector()->error());			
		//echo json_encode($datas);
		//exit();
		include $conf->root_path.'/view/'.'show_oceny.php';
	}
	public function showOne($number){
		global $conf;
		$datas = $this->db->connector()->select("msg", [
			"[>]users" => ["msg_user_id" => "user_id"]
			], [	
			"msg.msg",
			"msg.msg_id",
			"msg.msg_title",
			"msg.msg_date",
			"users.name"
		], [
			"msg.msg_id" => $this->number
		]);	
		//var_dump($this->db->connector()->error());			
		//echo json_encode($datas);
		//exit();
		include $conf->root_path.'/view/'.'show_article.php';	
	}
	public function getDemo(){
		$datas = $this->db->connector()->select("users", [
			"name",
			"user_id"
		]);
		echo json_encode($datas);
	}
	
	function getKursy(){
		$data = "'".$_POST["przedmiot"]."'";
		$datas = $this->db->connector()->query("SELECT k.nazwa,k.id_kurs from kursy k join przedmioty p on p.id_przedmiot = k.id_przedmiot where id_nauczyciel = $_SESSION[id] AND p.id_przedmiot = $data ")->fetchAll();
		echo json_encode($datas);
	}
	function setKurs(){
		$kurs = "'".$_POST["kurs"]."'";
		$id_nauczyciel = "'".$_SESSION["id"]."'";
		$id_przedmiot = "'".$_POST["idPrzedmiot"]."'";
		$data = "'".$_POST['dataKursu']."'";
		$query = "INSERT INTO `kursy` (`id_kurs`, `id_nauczyciel`, `id_przedmiot`, `nazwa`, `data_rozpoczecia`) VALUES (NULL,$id_nauczyciel,$id_przedmiot,$kurs,$data)";
		$this->db->connector()->query($query);
		$query = "SELECT MAX(id_kurs) as id from `kursy` ";
		$id=$this->db->connector()->query($query)->fetchAll();
		$this->setZajecia($id);
		$id = json_encode($id);
		echo $id;
	}
	function setUczen(){
		$id = "'".$_POST["id"]."'";
		$imie = "'".$_POST["imie"]."'";
		$nazwisko = "'".$_POST["nazwisko"]."'";
		$query = "INSERT INTO `uczeniowie` (`id_uczen`,`imie`, `nazwisko`, `id_kurs`) VALUES (NULL,$imie,$nazwisko,$id)";
		$this->db->connector()->query($query);
	}
	function setZajecia($kurs){
		$iloscZajec = $_POST['iloscZajec'];
		$datakursu = $_POST['dataKursu'];
		$datakursu1 = "'".$_POST['dataKursu']."'";
		$id_kurs =  $kurs[0];
		$id_kurs1 = "'".$id_kurs["id"]."'";
		for($i = 0; $i < $iloscZajec; $i++){
			$query = "INSERT INTO `zajecia` (`id_zajecia`,`id_kurs`,`data`) VALUES (NULL,$id_kurs1,$datakursu1)";
			$this->db->connector()->query($query);
			$query = "SELECT MAX(id_zajecia) as id from `zajecia` ";
			$id=$this->db->connector()->query($query)->fetchAll();
			$datakursu =  date('Y-m-d', strtotime($datakursu. ' + 7 days'));
			$datakursu1 = "'".$datakursu."'";
		}
	}
	function getUczniowie(){
		$query="SELECT id_uczen,imie,nazwisko from uczeniowie u
		join zajecia z 
		on z.id_kurs = u.id_kurs
		where id_kurs = '87' AND id_zajecia = '30'
		";
		$datas = $this->db->connector()->query($query)->fetchAll();
			
		echo json_encode($datas);
	}
	function getZajecia(){
		$idKurs = "'".$_POST['id']."'";
		$datas = $this->db->connector()->query("SELECT id_zajecia,`data` from zajecia where id_kurs = $idKurs")->fetchAll();
			
		echo json_encode($datas);
	}
	function getJedneZajecia(){
		$idZajecia = "'".$_POST['idZajec']."'";
		$datas = $this->db->connector()->query("SELECT id_uczen,imie,nazwisko from uczeniowie u
		join zajecia z on z.id_kurs = u.id_kurs where z.id_zajecia = $idZajecia")->fetchAll();
			
		echo json_encode($datas);

	}
	function getObecnosc(){
		$idUczen = "'".$_POST['idUczen']."'";
		$idZajecia = "'".$_POST['idZajec']."'";
		$query="SELECT id_obecnosc,imie,nazwisko,id_zajecia,obecnosc from obecnosci o
		join uczeniowie u on u.id_uczen = o.id_uczen
		where id_zajecia = $idZajecia AND o.id_uczen = $idUczen";
		$datas = $this->db->connector()->query($query)->fetchAll();
		if($datas)echo json_encode($datas);
		
		else {$query = "INSERT INTO `obecnosci` (`id_obecnosc`, `id_uczen`, `id_zajecia`, `obecnosc`) 
		VALUES (NULL,$idUczen,$idZajecia,'nie')";
		$this->db->connector()->query($query);
		$query="SELECT id_obecnosc,id_uczen,id_zajecia,obecnosc from obecnosci
		where id_zajecia = $idZajecia AND id_uczen = $idUczen";
		$datas = $this->db->connector()->query($query)->fetchAll();
		echo $datas;
		}
		
	}
	function setObecnosc(){
		$obecnosc = $_POST['obecnosc'];
		if($obecnosc=='false')$obecnosc="'".'nie'."'";
		else $obecnosc="'".'tak'."'";
		$id_obecnosc= "'".$_POST['id_obecnosc']."'";
		$query = "UPDATE `obecnosci` SET obecnosc = $obecnosc where id_obecnosc = $id_obecnosc";
		echo $query;
		$this->db->connector()->query($query);
	}
	function setOcena(){
		$ocena = "'".$_POST["ocena"]."'";
		$id_zajecia = "'".$_POST["id_zajecia"]."'";
		$forma = "'".$_POST["forma"]."'";
		$waga = "'".$_POST["waga"]."'";
		$id_uczen = "'".$_POST["id_uczen"]."'";
		$query="INSERT INTO `oceny` (`id_oceny`, `ocena`, `id_zajecia`, `forma`, `waga`, `id_uczen`)
		VALUES (NULL,$ocena,$id_zajecia,$forma,$waga,$id_uczen)";
		echo $query;
		$datas = $this->db->connector()->query($query);
	}
	function updateOcena(){
		$ocena = "'".$_POST["ocena"]."'";
		$forma = "'".$_POST["forma"]."'";
		$waga = "'".$_POST["waga"]."'";
		$id_uczen = "'".$_POST["id_uczen"]."'";
		$id_ocena = "'".$_POST["id_ocena"]."'";
		$query="UPDATE oceny
		SET ocena = $ocena, forma = $forma, waga = $waga, id_uczen = $id_ocena
		WHERE id_oceny = $id_ocena";
		echo $query;
		$datas = $this->db->connector()->query($query);
	}
	function getOceny(){
		$idZajecia = "'".$_POST['idZajec']."'";
		$query="SELECT DISTINCT imie,nazwisko,ocena,forma,waga,u.id_uczen as id_uczen,id_oceny from uczeniowie u
		inner JOIN kursy k
		on k.id_kurs = u.id_kurs
		inner join zajecia z
		on z.id_kurs = k.id_kurs
        AND z.id_zajecia = $idZajecia
        LEFT join oceny o
        on u.id_uczen = o.id_uczen
        AND o.id_zajecia = $idZajecia";
		$datas = $this->db->connector()->query($query)->fetchAll();
		echo json_encode($datas);
	}
	function getOcenyWszystkie(){
		$id_kurs = "'".$_POST['idKurs']."'";
		$query="SELECT DISTINCT imie,nazwisko,ocena,forma,waga,u.id_uczen as id_uczen,id_oceny from uczeniowie u
		inner JOIN kursy k
		on k.id_kurs = u.id_kurs
		inner join zajecia z
		on z.id_kurs = k.id_kurs
        AND z.id_kurs = $id_kurs
        LEFT join oceny o
		on u.id_uczen = o.id_uczen";
		$datas = $this->db->connector()->query($query)->fetchAll();
		echo json_encode($datas);
	}
	function delOcena(){
		$id_ocena = "'".$_POST['id_ocena']."'";
		$query="DELETE FROM oceny where id_oceny = $id_ocena";
		$datas = $this->db->connector()->query($query);
		echo json_encode('Usunieto');
	}
}
