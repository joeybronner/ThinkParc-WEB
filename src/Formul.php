<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Enregistrer un vehicule</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/templatemo_main.css">
		<link rel="stylesheet" href="../css/app.css">
		<link rel="stylesheet" href="../css/formulairevehicule_files/formoid1/formoid-solid-dark.css" type="text/css">
		<script type="text/javascript" src="../css/formulairevehicule_files/formoid1/jquery.min.js"></script>
		<script src="../js/jquery.min.js"></script>
        <script src="../js/jquery.backstretch.min.js"></script>
        <script src="../js/templatemo_script.js"></script>
		<script src="../js/bootstrap.js"></script>
	</head>
<body>

	<?php include('./navbar.html'); ?>

<!-- Start Formoid form-->
<img src="../images/vehicules.jpg" class="main-img inactive" alt="FCT Partners">

<form class="formoid-solid-dark" method="get" action="enregistrementvehicule.php">
	
	<!-- style="background-color:#7d7d7d;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#005500;max-width:80%;min-width:50%" -->
	<div class="title">Nouveau véhicule</div>
	
	<div class="element-select">
		<label class="title">INFORMATIONS GENERALES</label>
		<div class="item-cont">
			<div class="large"><span>
				<select name="genre" required="required">
					<option value="" disabled selected>Sélectionnez le type de véhicule</option>
					<option value="Vehicule Particulier">Véhicule Particulier</option>
					<option value="Camionnette de PTAC < ou = 3,5 tonnes">Camionnette de PTAC < ou = 3,5 tonnes</option>
					<option value="Tricycle ">Tricycle </option>
					<option value="Quadricycle ">Quadricycle </option>
					<option value="Vehicule utilitaire">Véhicule utilitaire</option>
					<option value="Moto ">Moto </option>
					<option value="Tracteur routier">Tracteur routier</option>
					<option value="Transport en commun de personne">Transport en commun de personne</option>
				</select><span class="icon-place"></span></span>
			</div>
		</div>
	</div>
	
	<div class="element-select">
		<div class="item-cont">
			<div class="large"><span>
				<select name="categorie" required="required">
					<option value="" disabled selected>Sélectionnez la catégorie du véhicule</option>
					<option value="Vehicules legers">Véhicules légers</option>
					<option value="Vehicules intermediaires">Véhicules intermédiaires</option>
					<option value="Poids lourds et autocars a 2 essieux">Poids lourds et autocars à 2 essieux</option>
					<option value="Poids lourds et autocars a 3 essieux et plus">Poids lourds et autocars à 3 essieux et plus</option>
					<option value="Moto">Moto</option>
				</select><span class="icon-place"></span></span>
			</div>
		</div>
	</div>
	
	<div class="element-select">
		<div class="item-cont">
			<div class="large"><span><select name="energie" required="required">
				<option value="" disabled selected>Sélectionnez le type de carburant</option>
				<option value="Essence">Essence</option>
				<option value="Diesel">Diesel</option>
				<option value="GPL">GPL</option></select><i></i><span class="icon-place"></span></span>
			</div>
		</div>
	</div>
	
	<div class="element-input">
		<div class="item-cont">
			<input class="large" type="text" name="kilometrage" required="required" placeholder="Kilométrage"/><span class="icon-place"></span>
		</div>
	</div>
	
	<div class="element-input" title="numero de serie">
	<label class="title">NUMEROS D'IDENTIFICATION</label>
		<div class="item-cont">
			<input class="large" type="text" name="numerodeserie" required="required" placeholder="Numéro de série"/><span class="icon-place"></span>
		</div>
	</div>
	
	<div class="element-input" title="matricule">
		<div class="item-cont">
			<input class="large" type="text" name="matricule" required="required" placeholder="Numéro d'immatriculation"/><span class="icon-place"></span>
		</div>
	</div>
	
	<div class="element-date" title="dateachat">
		<div class="item-cont">
			<label class="info">Date d'achat</label>
			<input class="medium" data-format="yyyy-mm-dd" type="date" name="dateachat" required="required"/>
		</div>
	</div>
	
	<div class="element-date" title="misecirculation">
		<div class="item-cont">
			<label class="info">Date de première mise en circulation</label>
			<input class="medium" data-format="yyyy-mm-dd" type="date" name="misecirculation"/>
		</div>
	</div>
	
	<div class="element-select">
		<label class="title">EQUIPEMENTS SPECIAUX</label>
		<div class="item-cont">
			<div class="large"><span>
				<select name="equipement" >
					<option value="Kit Hydraulique">Kit Hydraulique</option>
					<option value="Godet">Godet</option>
				</select>
				<span class="icon-place"></span></span>
			</div>
		</div>
	</div>	
	
	<div class="element-select">
		<label class="title">AFFECTATION</label>
		<div class="item-cont">
			<div class="large"><span>
				<select name="affectation" required="required">
					<option value="site 1">Site A</option>
					<option value="site 2">Site B</option>
					<option value="site 3">Site C</option>
				</select><span class="icon-place"></span></span>
			</div>
		</div>
	</div>
	
	<div class="element-textarea"><label class="title"></label>
		<div class="item-cont">
			<textarea class="small" name="commentaire" cols="20" rows="5" placeholder="Commentaires "></textarea>
			<span class="icon-place"></span>
		</div>
	</div>
		
		<input type="checkbox" class="large"/>
      </label>
	<div class="element-checkbox">
		<label class="info">Etat</label>
	
		<input type="checkbox" name="etat" value="Hors Parc"><span style="color:white;">Hors parc</span><span class="clearfix"></span>
		<input type="checkbox" name="etat" value="Reforme"><span style="color:white;">Réformé</span><span class="clearfix"></span>
		<input type="checkbox" name="etat" value="Vendu"><span style="color:white;">Vendu</span><span class="clearfix"></span>
	</div>
	
	<div class="submit">
		<input type="submit" value="Enregistrer"/>
	</div>
</form>



</body>
</html>
