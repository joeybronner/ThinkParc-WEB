<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();

// Récupérer l'ID dans l'URL
$id = $_GET["id"];

// Execution de la requête
$dbh->deleteNews($id);
header('Location: myinformations.php'); 
?>