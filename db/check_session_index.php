<?php
try {
	if (isset($_SESSION['fct_token'])) {
		if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
			header("location: http://127.0.0.1/projects/ThinkParc-WEB/src/accueil.php");
		} else {
			header("location: http://www.think-parc.com/src/accueil.php");
		}		
	} else {
		// Session initialization
		session_start();

		// Unset all of the session variables.
		$_SESSION = array();

		// Delete the session cookie
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		
		// Delete Cookie
		//setcookie("fct_token", "", time()-3600);

		// Finally, destroy the session
		session_destroy();
	}
} catch (Exception $e) {
	// Nothing
} 
?>