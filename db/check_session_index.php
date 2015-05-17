<?php
session_start();
try {
	if (($_SESSION['fct_id_user']) != "") {
		if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
			header("location: http://127.0.0.1/projects/ThinkParc-WEB/src/accueil.php");
		} else {
			header("location: http://www.think-parc.com/src/accueil.php");
		}		
	}
} catch (Exception $e) {
	// Nothing
} 
?>