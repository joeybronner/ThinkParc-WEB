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
	$password=md5($_POST['pass']);

	// Check if login exists
	$query = "SELECT * FROM users WHERE login='" . $login . "'";
	$resultLogin = $connection->query($query); 

	if(mysqli_num_rows($resultLogin)==0) {
		$data = array(
				  "access" => "denied",
				  "token" => "Login"
				);
		echo json_encode($data);
		exit();
	} else {
		// Check if login & password are OK
		$user_profile = $connection->query($query . " AND pass='" . $password . "'") or die (mysqli_error());

		if(mysqli_num_rows($user_profile)==0) {
			$data = array(
					  "access" => "denied",
					  "token" => "Password"
					);
			echo json_encode($data);
			exit();
		}
		else
		{
			// Retrieve user data
			$results = mysqli_num_rows($user_profile);
			$user = mysqli_fetch_assoc($user_profile);
			
			// Expire token
			$stamp_expire = date('Y-m-d H:i:s', strtotime("+15 min"));
			
			$user_cred = array (
				'login'    	=> $user['login'],
				'firstname' => $user['firstname'],
				'lastname' 	=> $user['lastname'],
				'email' 	=> $user['email'],
				'time' 	=> time());

			// Generate Token 
			$token = new AuthenticationToken();
			$authToken = $token->GetTokenByArray($user_cred);
			
			// Database insertion for token values
			$querySession = "INSERT INTO users_auth_tokens (id_user,expire,token) VALUES (".$user['id_user'].",'".$stamp_expire."','".$authToken."')";
			$session = $connection->query($querySession) or die (mysqli_error());
			
			if ($results) {
				session_start();
				// Private session cache & expires in a delay of 15 minutes
				session_cache_limiter('public');
				session_cache_expire(15);
				// Write JSON
				$data = array(
					      "access" => "success",
						  "token" => $authToken, 
						  "id_company" => $user['id_company'],
						  "id_role" => $user['id_role'], 
						  "id_user" => $user['id_user'],
						  "firstname" => $user['firstname'],
						  "lastname" => $user['lastname'],
						  "login" => $user['login'],
						  "email" => $user['email'],
						  "image" => $user['image']
						);
				echo json_encode($data);
			} 
		}
	}
}

?>
