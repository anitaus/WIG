<?php
            echo '<div class="container">
			   <div id="menu">
				   <div class="menuItem"><a  href="'.$conf->app_root.'/view/przedmioty">Obecnosci</a></div>
				   <div class="menuItem"><a  href="'.$conf->app_root.'/view/oceny">Oceny</a></div>
                   ';
            if(!isset($_SESSION['id']))echo '<div class="menuItem"><a href="'.$conf->app_root.'/account".">Logowanie</a></div>';
            else echo '<div class="menuItem"><a href="'.$conf->app_root.'/logout".">Wyloguj</a></div>';
				   echo'<div style="clear:both;"></div>

			   </div>
						
                </div>';
?>