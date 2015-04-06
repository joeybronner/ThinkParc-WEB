<?php

$DB_serveur = 'thinkparqnroot.mysql.db'; 		// Server
$DB_utilisateur = 'thinkparqnroot'; 		// Username
$DB_motdepasse = 'Thinkparc1'; 			// Password
$DB_base = 'thinkparqnroot'; 				// Database name

// Server connection
$connection = mysqli_connect($DB_serveur, $DB_utilisateur, $DB_motdepasse, $DB_base) 
or die("Error " . mysqli_error($connection));

?>