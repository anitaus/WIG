<?php 
if (!isset($_SESSION)){
		session_start();
	}
include $conf->root_path.'/view/header.php';

?>


	   <div class="container">
	  	 	<div class="col-lg-10 col-lg-offset-1 col-md-11 col-md-offset-1 col-sm-11 col-sm-offset-1"  >  
                <?php
                	foreach($datas as $data){		
						echo '<div id="art-'.$data["msg_id"].'">';	
						echo '<div class="post-preview">
						  <a href="'.$conf->app_root.'/view/'.$data["msg_id"].'/
						  "><h2 class="post-title"><mark><span style="width: 150px; ">';
						echo $data["msg_title"];
						echo '</span></mark>';
						echo '</h2></a>';
						echo '<p class="post-meta">Published ';
						echo localStrftime($data["msg_date"]).'</p></div>';
						echo '</div>';
												
						  echo '<div class="info"><p>';
						  echo '</p></div>';
					  	}
						if (!isset($data["msg"])){
							echo '
							<div class="text-center">
							  <a>
								<h2 class="post-title">
								  <mark>
									<span style="width: 150px; ">
									  Nie znaleziono artykułów
									</span>
								  </mark>
								  <mark class="mark-404">
									<span>404</span>
								  </mark>
								</h2>
							  </a>
							  </a>
							</div>
							';
						
						}
                ?>


	</div>
</div>
		
	
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


			


