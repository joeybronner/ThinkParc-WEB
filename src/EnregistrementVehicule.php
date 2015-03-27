<?php

require_once('./connexion.php'); 
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
   <style type="text/css">
	.bs-example{
		margin: 40px;
		font-size: 30px;
	}
</style>
       
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,600,500,300,700' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/templatemo_main.css">
		<link rel="stylesheet" href="../css/app.css">
    </head>
    <body>
	<div class="madiv">
		<a href="index.php?erreur=logout" class="btn btn-sm btn-danger">Deconnexion <span class="glyphicon glyphicon-off"></span></a>
	
		</div>
		
		<!-- if success-->
		<?php

			if($dbh->RecordCar())
			{
			
			
		?>
<div class="bs-example">
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <center><strong>Success!</strong> La voiture a bien été ajouté.</center>
    </div>
</div>
<center><button class="btn btn-success btn-small" onClick="javascript:document.location.href='accueil.php'"><i class="icon-white icon-th-large"></i> Retour à l'accueil</button></center>

<?php
}
 else
{
?>
		<!-- no success-->
<div class="bs-example">
    <div class="alert alert-danger alert-error">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <center><strong>Erreur!</strong> Un problème est survenue lors de l'enregistrement.</center>
		<center><button class="btn btn-success btn-small" onClick="javascript:document.location.href='Formul.php'"><i class="icon-white icon-th-large"></i> Retour au formulaire</button></center>

    </div>
</div>
<?php

}
?>





		</body>
		</html>