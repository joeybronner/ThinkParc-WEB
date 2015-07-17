<?php

/* ======================================================================== *
 *																			*
 * @filename:		uploadfile.php											*
 * @description:	Script to upload file to server.						*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @lastupdate: 	22/04/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 22/04/2015 | J.BRONNER      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/

// Folder link where the file will be saved
$target_dir = $_GET['target']."/";
$target_file = $target_dir . basename($_FILES["myfiles"]["name"]);
$uploadOk = 1;

	// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
	if (move_uploaded_file($_FILES["myfiles"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["myfiles"]["name"]). " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}


?>