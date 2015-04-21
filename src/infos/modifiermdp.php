<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();


// Vérification si les 3 champs ont été complétés
if(isset($_POST["ancienmdp"]) && !empty($_POST['ancienmdp']) && !empty($_POST['nouveaumdp']) && isset($_POST["nouveaumdp"]) && !empty($_POST['confirmationmdp']) && isset($_POST["confirmationmdp"])) {
	$dbh->getinfouser();			
	foreach ($dbh->getinfouser() as $Valeur) {
		$mdp = $Valeur['password'];
	}
	if ($mdp == $_POST['ancienmdp']) {
		if ($_POST['nouveaumdp'] == $_POST['confirmationmdp']) {
			if ($dbh->updatePassword($_POST['nouveaumdp']) == "error") {
				$_SESSION['fct_message'] = "Erreur lors de la mise à jour du mot de passe.";
				header('Location: myinformations.php?pass=failed'); 
			} else {
				$_SESSION['fct_message'] = "Mot de passe mis à jour avec succès.";
				header('Location: myinformations.php?pass=success'); 
			}
		} else {
			$_SESSION['fct_message'] = "Votre confirmation de mot de passe n'est pas identique à votre nouveau mot de passe.";
			header('Location: myinformations.php?pass=failed'); 
		}
	} else {
		$_SESSION['fct_message'] = "Ancien mot de passe incorrect.";
		header('Location: myinformations.php?pass=failed'); 
	}
} else {
	$_SESSION['fct_message'] = "Les trois champs sont obligatoires.";
	header('Location: myinformations.php?pass=failed'); 
}

?>