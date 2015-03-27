<?php

// Paramètres de connexion
    $dbhost="localhost";
    $dblogin="root";
    $dbpwd="";
    $dbname="FCT";
       
    $db =  mysqli_connect($dbhost,$dblogin,$dbpwd,$dbname);
    
	/* Vérification de la connexion */ 
if (mysqli_connect_errno()) {
    printf("Echec de la connexion: %s\n", mysqli_connect_error());
    exit();
	}
	
?>