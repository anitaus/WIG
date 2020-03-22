<?php require_once dirname(__FILE__) .'/../config.php';
if (!isset($_SESSION)){
		session_start();
	}
?>

<!DOCTYPE html>
<html lang="pl" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>E-Dziennik</title>
		
		<link href='http://fonts.googleapis.com/css?family=Advent+Pro&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lato:300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700' rel='stylesheet' type='text/css'>

		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

		
		<?php
		echo'

		
		
			<script type="text/javascript" src="'.$conf->app_root.'/js/jquery.cookie.js"></script>
			<link rel="stylesheet" type="text/css" href="'.$conf->app_root.'/css/jquery.cookie.css" />
			<link rel="stylesheet" type="text/css" href="'.$conf->app_root.'/css/special/form.css" />
			<link rel="stylesheet" href="'.$conf->app_root.'/css/style.css" type="text/css" />
			
		';
		
		?>	
<style>
.boldGray{
	font-weight: bold;
	color: gray;
}
.no-bullet{
	list-style: none;
}
.horizontal-list{
	float: left;
}
.marked{
	text-decoration: underline;
	font-weight: bold;
}
</style>




	</head>
    <body>

	<script>
		$.cookieBar({
		    fixed: true,
		    acceptOnScroll: 200
		});
	</script>  	
	<script>
	    function validateEmail($email) {
	     var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	     return emailReg.test( $email );
	   }
	</script>

	
