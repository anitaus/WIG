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
	 						echo '<div class="post-preview">
	 						  <a href="'.$conf->app_root.'/view/'.$data["msg_id"].'/
	 						  "><h2 class="post-title"><mark>';
						  
	 						echo $data["msg_title"];
						
	 						echo '</mark>';
	 						echo '</h2></a>';
							
	 						echo '<p class="post-meta">Published ';
	 						echo localStrftime($data["msg_date"]).'</p>';

	 						echo '</p></div>';
	 						echo '<div class="info"><p>'.$data["msg"];
						
	 						echo '</p>
	 						</div><br>
	 						';
						
	 						}
	 						if (!isset($data["msg"])){
	 							echo '
	 							<div class="text-center">
	 							  <a>
	 								<h2 class="post-title">
	 								  <mark>
	 									<span style="width: 150px; ">
	 									  Nie znaleziono artykułu
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



	   
 	  
		

<script>
$( document ).ready(function() {		
	var response = $.ajax({					
		type: "GET",
		url: "<?php echo $conf->app_root.'/get/demo' ?>",
		dataType : 'json',
		async: false,
		data: {
		},
		success: function(json){
		}
	}).responseText;
	alert(response);		
});
</script>

			


