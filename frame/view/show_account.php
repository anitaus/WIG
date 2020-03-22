<?php 
if (!isset($_SESSION)){
		session_start();
	}
include $conf->root_path.'/view/header.php';
include $conf->root_path.'/view/show_menu.php';
$db = new DatabaseCtrl();
$przedmioty = $this->db->connector()->select("przedmioty", [
	"nazwa",
	"id_przedmiot"
]);
echo '
<div class="container" style="margin-top:25px; margin-left:10px">
		  <div class="col-lg-10 col-lg-offset-1 col-md-11 col-md-offset-1 col-sm-11 col-sm-offset-1"  > 
	<form id="form" class="form-signin">
			 <input id="inputEmail" type="email" class="form-control" placeholder="Email" autofocus>
			 <input id="inputPass"  type="password" class="form-control" placeholder="Hasło">
			 <button id="login" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Zaloguj</button>
	</form> 
	<div class="alert alert-danger alert-dismissable" id="msg" style="display: none"></div>
 </div>
</div>
 ';
?>


<script>
$( document ).ready(function() {
	$('#form').submit(function(event){
		event.preventDefault();
		var email = $("#inputEmail").val();
		var pass = $("#inputPass").val();
		if (email == '' || pass == ''){
			$('#msg').html('Nie wypełniono wszystkich pól');
			$('#msg').show();
			setTimeout(function() {
				$('#msg').fadeOut('fast');
			}, 1000);
		}
		else{
			$.ajax({
				type: "POST",
				url: "<?php echo $conf->app_root.'/login' ?>",
				dataType : 'json',
				data: {
					login : email,
					pass: pass
				},
				success: function(json){
					if (json[0]['status'] == 'err'){
						$('#msg').html('Wprowadzone dane są nieprawidłowe');
						$('#msg').show();
						$("#inputPass").val('');
						$("#inputPass").prop('disabled', true);
						$('#login').attr('disabled','disabled');
						setTimeout(function() {
							$('#msg').fadeOut('slow');
							$('#login').removeAttr('disabled');
							$("#inputPass").prop('disabled', false);
						}, 5000);
					}
					else if (json[0]['status'] == 'ok'){
						window.location.replace("<?php echo $conf->app_root.'/view/przedmioty' ?>");
					}
				}
			});
		}
	});
});



</script>
			


