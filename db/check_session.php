<?php
session_start();
if (isset($_SESSION["fct_session"])) {
	if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
		header("location: http://127.0.0.1/projects/ThinkParc-WEB/index.html");
	} else {
		header("location: http://www.think-parc.com");
	}
}
?>