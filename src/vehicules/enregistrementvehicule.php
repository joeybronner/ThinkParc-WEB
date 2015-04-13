<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();
?>

<html> 
    <head>
        <meta charset="utf-8">
        <title>FCT Partners</title>
        <meta name="description" content="">
        <meta name="" content="width=device-width">
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,600,500,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="stylesheet" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">
    </head>
    <body>
	<div>
		<?php
			if($dbh->RecordCar()) {
		?>
			<!-- if success-->
			<div class="bs-example">
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<center><strong>Success!</strong> La voiture a bien été ajouté.</center>
				</div>
			</div>
			<center>
				<button class="btn btn-success btn-small" onClick="javascript:document.location.href='accueil.php'">
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
					<center><strong>Erreur!</strong> Un problème est survenue lors de l'enregistrement.</center>
					<center><button class="btn btn-success btn-small" onClick="javascript:document.location.href='ajoutvehicule.php'">
					Retour au formulaire</button></center>
				</div>
			</div>
		<?php
		}
		?>
	</body>
</html>