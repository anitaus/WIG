<?php
require_once dirname(__FILE__).'/config.php';
/*require_once dirname(__FILE__).'/app/install/InstallCtrl.class.php';
$install = new InstallCtrl();
$install->install();*/
header("Location: ".$conf->action_root);
?>
