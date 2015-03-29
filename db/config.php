<?php

$DB_serveur = 'localhost'; 		// Server
$DB_utilisateur = 'root'; 		// Username
$DB_motdepasse = ''; 			// Password
$DB_base = 'fct'; 				// Database name

// Server connection
$connection = mysqli_connect($DB_serveur, $DB_utilisateur, $DB_motdepasse, $DB_base) 
or die("Error " . mysqli_error($connection));

?>