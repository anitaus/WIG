<?php 
if (!isset($_SESSION)){
		session_start();
	}
include $conf->root_path.'/view/header.php';
include_once $conf->root_path.'/view/show_menu.php';
$db = new DatabaseCtrl();
$przedmioty = $this->db->connector()->select("przedmioty", [
	"nazwa",
	"id_przedmiot"
]);
?>
	
	   <div id="container-left">
		   <h3>Wybierz przedmiot: </h3>
		   <?php  
		   	echo "<h4><ul>";
		 	  foreach($przedmioty as $przedmiot){
				$html = "<li> <a href='javascript:pobierzKursy(".'"';
				$html .="$przedmiot[id_przedmiot]".'"'.")'".">$przedmiot[nazwa]</a></li>";
			   echo $html;
		   }
		   echo "</h4></ul>";
		   ?>
		   </div>
		<div id="container-right"></div>
		
<script src="../js/przedmioty.js"></script>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


			


