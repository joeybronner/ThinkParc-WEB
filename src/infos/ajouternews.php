<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();

// Vérification si une image a été submittée
if(isset($_POST["submit"])) {
	$msg = $_POST['newstext'];
	$auteur = $_SESSION['fct_prenom']." ".$_SESSION['fct_nom'];
	if ($dbh->addNews($msg, $auteur, 1)) {
		header('Location: myinformations.php?news=success'); 
	} else {
		$_SESSION['fct_message'] = "Erreur lors de l'ajout de la news. Veuillez réessayer";
		header('Location: myinformations.php?news=failed'); 
	}
}


?>