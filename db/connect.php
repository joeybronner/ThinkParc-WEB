<?php
/* 
* Start PHP session
* Login & Password from user
*/

require('authenticationtoken.php');

$DB_serveur = 'thinkparqnroot.mysql.db';
$DB_utilisateur = 'thinkparqnroot';
$DB_motdepasse = 'Thinkparc1';
$DB_base = 'thinkparqnroot';

// Server connection
$connection = mysqli_connect($DB_serveur, $DB_utilisateur, $DB_motdepasse, $DB_base) 
or die("Error " . mysqli_error($connection));


/* If POST */
if(isset($_POST['login']) && isset($_POST['pass'])) {
	
	// Retrieve values for login & password
	$login=$_POST['login'];
	$password=$_POST['pass'];

	// Check if login exists
	$query = "SELECT * FROM users WHERE login='" . $login . "'";
	$resultLogin = $connection->query($query); 

	if(mysqli_num_rows($resultLogin)==0) {
		// Login don't exist
		header('Location: ../index.php');
		exit();
	} else {
		// Check if login & password are OK
		$user_profile = $connection->query($query . " AND pass='" . $password . "'") or die (mysqli_error());

		if(mysqli_num_rows($user_profile)==0) {
			header('Location: ../index.php');
			exit();
		}
		else
		{
			// Retrieve user data
			$results = mysqli_num_rows($user_profile);
			$user = mysqli_fetch_assoc($user_profile);
			
			// Expire token
			$stamp_expire = date('Y-m-d H:i:s', strtotime("+30 min"));
			
			$user_cred = array (
				'login'    	=> $user['login'],
				'firstname' => $user['firstname'],
				'lastname' 	=> $user['lastname'],
				'email' 	=> $user['email']);

			// Generate Token 
			$token = new AuthenticationToken();
			$authToken = $token->GetTokenByArray($user_cred);
			
			// Database insertion for token values
			$querySession = "INSERT INTO users_auth_tokens (id_user,expire,token) VALUES (".$user['id_user'].",'".$stamp_expire."','".$authToken."')";
			$session = $connection->query($querySession) or die (mysqli_error());
			
			if ($results) {	
				session_start();
				$_SESSION['fct_session'];
				$_SESSION['fct_id_user'] 	= $user['id_user'];
				$_SESSION['fct_id_role'] 	= $user['id_role'];
				$_SESSION['fct_id_company'] = $user['id_company'];
				$_SESSION['fct_firstname'] 	= $user['firstname'];
				$_SESSION['fct_lastname'] 	= $user['lastname'];
				$_SESSION['fct_login'] 		= $user['login'];
				$_SESSION['fct_pass'] 		= $user['pass'];
				$_SESSION['fct_email'] 		= $user['email'];
				$_SESSION['fct_image'] 		= $user['image'];
				$_SESSION['fct_token'] 		= $authToken;
				$cookie_name = "fct_token";
				$cookie_value = $authToken;
				setcookie($cookie_name, $cookie_value, time() + (60 * 15), "/"); // 86400 = 1 day
				// Private session cache & expires in a delay of 15 minutes
				session_cache_limiter('public');
				session_cache_expire(30);
				// Okay, redirect.
				header('Location: ../src/accueil.php'); 
			} else {
				header('Location: ../index.php');
			}
		}
	}
}

?>
