<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Formulaire administratif </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		     <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">
</head>
<body class="blurBg-true" style="background-color:#a6a6a6">


	<?php
	
		include('../header/navbar.php');
	?>
<!-- Start  form-->
<link rel="stylesheet" href="../../css/formulairevehicule_files/formoid1/formoid-solid-dark.css" type="text/css" />
<script type="text/javascript" src="../../css/formuladministratif_files/formoid1/jquery.min.js"></script>
<form class="formoid-solid-dark" style="background-color:#888888;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#34495E;max-width:520px;min-width:150px" method="get" action="ajoutadministratif.php"><div class="title"><h2>Formulaire administratif</h2></div>
	<div class="element-select"><div class="item-cont"><span><select name="matricule" class="medium" >
	<option selected disabled>Matricule de la machine</option>
	<?php 

		$dbh = new db_functions();
	foreach ($dbh->getimmatriculation() as $Valeur)
    {
	?>
	
		<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['matricule'];?></option>
		
	<?php
	}
	?>
		</select></span><i></i><span class="icon-place"></span></div></div>
		
	<div class="element-date"><label class="title">Date du dernier contrôle technique  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   Date du prochain contrôle technique</label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="derniercontrole" placeholder="Date du dernier contrôle technique"/><input class="medium" data-format="yyyy-mm-dd" type="date" name="prochaincontrole" placeholder="Date du prochain Contrôle technique "/><span class="icon-place"></span></div></div>
	<div class="element-input"><label class="title"></label>
<div class="item-cont"><input class="medium" type="text" name="numcontratassurance" placeholder="N° Contrat Assurance"/><input class="medium" type="text" name="prixachat" placeholder="Prix d'achat"/></div>
</div></div>	


<div class="element-select"><div class="item-cont"><span><select name="assurance" class="medium" >
	<option selected disabled>Assureur</option>
	<?php 

		$dbh = new db_functions();
	foreach ($dbh->getassurance() as $Valeur)
    {
	?>
	
		<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['nomassurance'];?></option>
		
	<?php
	}
	?>
		</select></span><i></i><span class="icon-place">
		<select name="fournisseur" class="medium" >
	<option selected disabled>Fournisseur</option>
	<?php 

		$dbh = new db_functions();
	foreach ($dbh->getfournisseur() as $Valeur)
    {
	?>
	
		<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['fournisseur'];?></option>
		
	<?php
	}
	?>
		</select></span><i></i><span class="icon-place"></span></div></div>

	<div class="element-date"><label class="title">Date échéance assurance </label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="echeanceassurance" placeholder="Date échéance assurance "/><span class="icon-place"></span></div></div>
	<div class="element-textarea"><label class="title"></label><div class="item-cont"><textarea class="small" name="conducteur" cols="20" rows="5" placeholder="Nom du (des) conducteur(s) "></textarea><span class="icon-place"></span></div></div>
<div class="submit"><input type="submit" value="Enregistrer"/></div></form>
<!-- Stop  form-->



</body>
</html>
