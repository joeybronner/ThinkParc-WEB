<?php
/* ======================================================================== *
 *																			*
 * @filename:		removefile.php											*
 * @description:	Script to remove file to server.						*
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

// Define target and path file
$target = $_GET['target']."/";
$path = $_POST['path'];

// Delete file using unlike method
unlink($target.$path);
?>