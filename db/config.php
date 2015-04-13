<?php

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

?>