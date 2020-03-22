<?php 
if (!isset($_SESSION)) session_start();
include $conf->root_path.'/view/header.php';
?>
<div class="container">
   	<div class="col-lg-10 col-lg-offset-1 col-md-11 col-md-offset-1 col-sm-11 col-sm-offset-1"  > 
   	<h1><?php echo $header; ?></h1>
	<p><?php echo $txt; ?></p>
    </div>
</div>

			


