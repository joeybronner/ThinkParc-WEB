<?php
	// Lien du dossier ou sera enregistrée l'image
	$now = date('ymdHis');
	$target_dir = $_GET['target']."/".$now;
	$target_file = $target_dir . basename($_FILES["myfiles"]["name"]);
	$uploadOk = 1;
	//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	/*$check = getimagesize($_FILES["myfiles"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}*/
	// Check if file already exists
	/*if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}*/
	// Check file size
	/*if ($_FILES["myfiles"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}*/
	// Allow certain file formats
	/*if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}*/
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 1) {
		if (move_uploaded_file($_FILES["myfiles"]["tmp_name"], $target_file)) {
			//$dbh->Recordlogo(basename( $_FILES["myfiles"]["name"]));
			echo "The file ". basename( $_FILES["myfiles"]["name"]). " has been uploaded.";
			//header('Location: myinformations.php'); 
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}


?>