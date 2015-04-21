<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();

// Lien du dossier ou sera enregistrée l'image
$target_dir = "users_images/";

$date = date_create();
$now = date_timestamp_get($date);

$target_file = $target_dir . $now . "_" . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Vérification si une image a été submittée
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
			// Vérification que la taille maximale n'est pas dépassée
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				$_SESSION['fct_message'] = "Le fichier selectionné est trop volumineux.";
				header('Location: myinformations.php?add=failed'); 
			} else {
				// Vérification si le format de l'image est correct
				if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					$_SESSION['fct_message'] = "Les extensions autres que JPG, JPEG, PNG & GIF ne sont pas acceptées.";
					header('Location: myinformations.php?add=failed'); 
				} else {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
						$dbh->Recordlogo($now . "_" . basename( $_FILES["fileToUpload"]["name"]));
						$_SESSION['fct_message'] = "L'image a été modifiée avec succès.";
						header('Location: myinformations.php?add=success'); 
					} else {
						$_SESSION['fct_message'] = "Une erreur inattendue est survenue lors de l'envoi de l'image.";
						header('Location: myinformations.php?add=failed'); 
					}
				}
			}
		
    } else {
        $_SESSION['fct_message'] = "Veuillez sélectionner une image.";
		header('Location: myinformations.php?add=failed'); 
    }
}


?>