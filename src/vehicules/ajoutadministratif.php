<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();
?>

<html class="no-js"> 
    <head>
		<title>FCT Partners</title>
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
        <meta name="description" content="">
		<meta charset="utf-8">
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="stylesheet" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">
    </head>
    <body>

	<!-- if success-->
	<?php
		if($dbh->RecordAdministratif()) {	
	?>
		<div class="bs-example">
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<center><strong>Success!</strong> La fiche administrative a bien été ajouté.</center>
			</div>
		</div>
		<center>
			<button class="btn btn-success btn-small" onClick="javascript:document.location.href='../accueil.php'">
			Retour à l'accueil
			</button>
		</center>
	<?php
	} else {
	?>
		<!-- no success-->
		<div class="bs-example">
			<div class="alert alert-danger alert-error">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<center><strong>Erreur!</strong> Un problème est survenue lors de l'enregistrement de la fiche administrative.</center>
				<center><button class="btn btn-success btn-small" onClick="javascript:document.location.href='administratif.php'"><i class="icon-white icon-th-large"></i> Retour au formulaire</button></center>
			</div>
		</div>
	<?php
	}
	?>
	</body>
</html>