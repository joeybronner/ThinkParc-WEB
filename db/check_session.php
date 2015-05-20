<?php
try {
	if (($_SESSION['fct_id_user']) == "") {
		throw new Exception("error");
	}
} catch (Exception $e) {
	if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
		header("location: http://127.0.0.1/projects/ThinkParc-WEB/index.php");
	} else {
		header("location: http://www.think-parc.com");
	}
} 
?>