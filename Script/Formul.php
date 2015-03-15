<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Ajout véhicule - Formoid html contact form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,600,500,300,700' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/templatemo_main.css">
		<link rel="stylesheet" href="../css/app.css">
		<link rel="stylesheet" href="../css/formul_files/formoid1/formoid-flat-green.css" type="text/css" />
		
</head>
<body class="blurBg-false" style="background-color:#9d99a2">

	
	<?php
	
		include('./navbar.html');
	?>


<!-- Start Formoid form-->
<form action="EnregistrementVehicule.php" enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#dcd5d6;font-size:14px;font-family:'Lato', sans-serif;color:#313131;max-width:480px;min-width:150px" method="get"><div class="title"><h2>Ajout véhicule</h2></div>
	<div class="element-select" title="Marque du véhicule"><label class="title">Marque</label><div class="medium"><span><select name="marque" >

		<option value="Renault">Renault</option>
		<option value="Citroën">Citroën</option>
		<option value="Peugeot">Peugeot</option>
		<option value="Audi">Audi</option>
		<option value="Mercedes">Mercedes</option>
		<option value="Toyota">Toyota</option></select><i></i></span></div></div>
	<div class="element-input" title="Modèle du véhicule"><label class="title">Modèle</label><input class="medium" type="text" name="modele" /></div>
	
	<div class="element-date"><label class="title">Mise en circulation</label><input class="medium" data-format="yyyy-mm-dd" type="date" name="misecirculation" placeholder="yyyy-mm-dd"/></div>
	
	<div class="element-radio"><label class="title">Chevaux</label>		<div class="column column3"><label><input type="radio" name="chevaux" value="4" /><span>4</span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="radio" name="chevaux" value="5" /><span>5</span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="radio" name="chevaux" value="6" /><span>6</span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="radio" name="chevaux" value="7" /><span>7</span></label></div><span class="clearfix"></span>
</div>
	<div class="element-radio"><label class="title">Energie</label>		<div class="column column3"><label><input type="radio" name="energie" value="Diesel		" /><span>Diesel		</span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="radio" name="energie" value="Essence" /><span>Essence</span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="radio" name="energie" value="GPL" /><span>GPL</span></label></div><span class="clearfix"></span>
</div>
	<div class="element-input"><label class="title">Kilométrage</label><input class="medium" type="text" name="kilometrage" /></div>
	<div class="element-name"><label class="title">Propriétaire</label><span class="nameFirst"><input  type="text" size="8" name="prenom" /><label class="subtitle">Prenom</label></span><span class="nameLast"><input  type="text" size="14" name="nom" /><label class="subtitle">Nom</label></span></div>
	<div class="element-file"><label class="title">Carte grise</label><label class="large" ><div class="button">Choisir un fichier</div><input type="file" class="file_input" name="cartegrise" /><div class="file_text">Aucun fichier selectionné</div></label></div>
<div class="submit"><input type="submit" value="Envoyer" /></div></form><p class="frmd"><script type="text/javascript" src="formul_files/formoid1/formoid-flat-green.js"></script>
<!-- Stop Formoid form-->


<script type="text/javascript" src="../js/formul_files/formoid1/jquery.min.js"></script>
</body>
</html>
