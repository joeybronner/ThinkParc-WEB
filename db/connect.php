<?php

/*
* Start PHP session
* Login & Password from user
*/

$login=$_POST['login'];
$password=$_POST['pass'];

require('config.php');

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
	$requete_2 = $connection->query($query . " AND password='" . $password . "'")
	or die ( mysqli_error() );

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
			$_SESSION['fct_authentification'];
			$_SESSION['fct_privilege'] = $user['privilege'];
			$_SESSION['fct_nom'] = $user['nom'];
			$_SESSION['fct_prenom'] = $user['prenom'];
			$_SESSION['fct_id'] = $user['id'];
			$_SESSION['fct_login'] = $user['login'];
			$_SESSION['fct_password'] = $user['password'];
			// Redirection
			header('Location: ../src/accueil.php'); 
		} else {
			header('Location: ../index.html');
		}
	}
}

?>
