<?php

require_once('../db/config.php'); 
include('./maclasse.php');
include('./MySQLExeption.php');

session_start();

$dbh = new maclasse();
//$dbh->RecordCar();
?>

<html class="no-js"> 
    <head>
        <meta charset="utf-8">
        <title>FCT Partners</title>
        <meta name="description" content="">
        <meta name="" content="width=device-width">
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,600,500,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/templatemo_main.css">
		<link rel="stylesheet" href="../css/app.css">
    </head>
    <body>
		

		<?php
			if(!empty($_GET['logo'])) {
			$dbh->Recordlogo();
		?>
			<!-- if success-->
			<div>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<center><strong>Success!</strong> Le logo a bien été ajouté.</center>
				</div>
			</div>
		<?php
		} else {
		?>
			<!-- no success-->
			<div>
				<div class="alert alert-danger alert-error">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<center><strong>Erreur!</strong> Un problème est survenue lors de l'enregistrement du logo.</center>
				</div>
			</div>
		<?php

		}
		?>

		<center>
			<button class="btn btn-success btn-small" onClick="javascript:document.location.href='accueil.php'">
			Retour à l'accueil
			</button>
		</center>
	</body>
</html>