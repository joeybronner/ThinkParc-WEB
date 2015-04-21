<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();

// Récupérer l'ID dans l'URL
$id = $_GET["id"];

// Vérification si les 3 champs ont été complétés
$currentValue = $dbh->getNewsStatus($id);

if ($currentValue == '0') {
	$newValue = 1;
} else {
	$newValue = 0;
}
// Execution de la requête
$dbh->updateNewsStatus($id, $newValue);
?>