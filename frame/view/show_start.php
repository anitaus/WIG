<?php 
if (!isset($_SESSION)) session_start();
include $conf->root_path.'/view/header.php';
?>
<div class="container">
   	<div class="col-lg-10 col-lg-offset-1 col-md-11 col-md-offset-1 col-sm-11 col-sm-offset-1"  > 
   	<h1>You are on starter page!!</h1>
    </div>
</div>
<script>
$( document ).ready(function() {		
	var response = $.ajax({					
		type: "GET",
		url: "<?php echo $conf->app_root.'/get/categories' ?>",
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

			


