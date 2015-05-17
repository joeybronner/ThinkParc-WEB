<?php


/*
* Start PHP session
* Login & Password from user
*/

$login=$_POST['login'];
$password=$_POST['pass'];

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
	$DB_serveur = '127.0.0.1'; 
	$DB_utilisateur = 'root'; 
	$DB_motdepasse = '';
	$DB_base = 'fct';
} else {
	$DB_serveur = 'thinkparqnroot.mysql.db';
	$DB_utilisateur = 'thinkparqnroot';
	$DB_motdepasse = 'Thinkparc1';
	$DB_base = 'thinkparqnroot';
}

// Server connection
$connection = mysqli_connect($DB_serveur, $DB_utilisateur, $DB_motdepasse, $DB_base) 
or die("Error " . mysqli_error($connection));

// Check if login exists
$query = "SELECT * FROM users WHERE login='" . $login . "'";
$result = $connection->query($query); 

if(mysqli_num_rows($result)==0)
{
	echo 'Ce login nexiste pas!<br/>';
	echo '<a href="../index.html" temp_href="index.html">Reessayer</a>';
	exit();
}
else
{
    // Check if login & password are OK
	$requete_2 = $connection->query($query . " AND pass='" . $password . "'")
	or die (mysqli_error());

	if(mysqli_num_rows($requete_2)==0)
	{
		echo 'Le mot de passe et/ou le login sont incorrectes <br/>';
		echo '<a href="../index.html" href="index.html">Reessayer</a>';
		exit();
	}
	else
	{
		// Retrieve user data
        $results = mysqli_num_rows($requete_2);
        $user = mysqli_fetch_assoc($requete_2);
		
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
			$_SESSION['fct_lang'] 		= 'FR';
			// Private session cache & expires in a delay of 15 minutes
			session_cache_limiter('private');
			session_cache_expire(15);
			// Okay, redirect.
			header('Location: ../src/accueil.php'); 
		} else {
			header('Location: ../index.html');
		}
	}
}

?>
