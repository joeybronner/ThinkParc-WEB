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
<!-- Start Formoid form-->
<link rel="stylesheet" href="../css/formulairevehicule_files/formoid1/formoid-solid-dark.css" type="text/css" />
<script type="text/javascript" src="../css/formulairevehicule_files/formoid1/jquery.min.js"></script>
<form class="formoid-solid-dark" style="background-color:#7d7d7d;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#005500;max-width:480px;min-width:150px" method="get" action="EnregistrementVehicule.php"><div class="title"><h2>Enregistrer un vehicule</h2></div>
<<<<<<< HEAD
	<div class="element-select">
		<label class="title">
			<span class="required">* Genre</span>
				</label>
					<div class="item-cont">
						<div class="large">
							<span>
							<select name="genre" required="required">

							<option value="Vehicule Particulier">Véhicule Particulier</option>
							<option value="Camionnette de PTAC < ou = 3,5 tonnes">Camionnette de PTAC < ou = 3,5 tonnes</option>
							<option value="Tricycle ">Tricycle </option>
							<option value="Quadricycle ">Quadricycle </option>
							<option value="Vehicule utilitaire">Véhicule utilitaire</option>
							<option value="Moto ">Moto </option>
							<option value="Tracteur routier">Tracteur routier</option>
							<option value="Transport en commun de personne">Transport en commun de personne</option>
							</select>
								<i></i>
									<span class="icon-place"></span>
							</span>
						</div>
					</div>
	</div>
	
	<div class="element-select">
		<label class="title">
			<span class="required">* Catégorie</span>
				</label>
					<div class="item-cont">
						<div class="large">
							<span>
								<select name="categorie" required="required">

								<option value="Vehicules legers">Véhicules légers</option>
								<option value="Vehicules intermediaires">Véhicules intermédiaires</option>
								<option value="Poids lourds et autocars a 2 essieux">Poids lourds et autocars à 2 essieux</option>
								<option value="Poids lourds et autocars a 3 essieux et plus">Poids lourds et autocars à 3 essieux et plus</option>
								<option value="Moto">Moto</option>
								</select>
			<i></i>
				<span class="icon-place"></span>
					</span>
						</div>
					</div>
	</div>
	
	<div class="element-select">
		<label class="title">
			<span class="required">* Carburant</span>
				</label>
					<div class="item-cont">
						<div class="large">
							<span>
								<select name="energie" required="required">

								<option value="Essence">Essence</option>
								<option value="Diesel">Diesel</option>
								<option value="GPL">GPL</option>
								</select>
								<i></i>
									<span class="icon-place"></span>
			</span>
					</div>
						</div>
	</div>
	
	<div class="element-input" title="numero de serie">
		<label class="title">
			<span class="required">*Numéro de série</span>
				</label>
					<div class="item-cont">
						<input class="large" type="text" name="numerodeserie" required="required" placeholder="Numéro de série"/>
						<span class="icon-place"></span>
				</div>
	</div>
	
	<div class="element-date" title="date">
		<label class="title"><span class="required">* Date
			</span>
				</label>
					<div class="item-cont">
						<input class="medium" data-format="yyyy-mm-dd" type="date" name="date" required="required" placeholder=" Date"/>
						<span class="icon-place"></span>
					</div>
	</div>
	
	<div class="element-input" title="matricule">
		<label class="title">
			<span class="required">* Matricule</span>
				</label>
					<div class="item-cont">
						<input class="large" type="text" name="matricule" required="required" placeholder="Matricule"/>
						<span class="icon-place"></span>
					</div>
	</div>
	
	<div class="element-date" title="dateachat">
		<label class="title">
			<span class="required">*</span>
				</label>
					<div class="item-cont">
						<input class="medium" data-format="yyyy-mm-dd" type="date" name="dateachat" required="required" placeholder="Date d’Achat"/>
						<span class="icon-place"></span>
					</div>
	</div>
	
	<div class="element-date" title="misecirculation">
		<label class="title"></label>
			<div class="item-cont">
				<input class="medium" data-format="yyyy-mm-dd" type="date" name="misecirculation" placeholder="Date de Mise en Route"/>
				<span class="icon-place"></span>
			</div>
	</div>
	
	<div class="element-input">
		<label class="title">
			<span class="required">* Compteur</span>
				</label>
					<div class="item-cont">
						<input class="large" type="text" name="kilometrage" required="required" placeholder="Compteur "/>
						<span class="icon-place"></span>
					</div>
	</div>
	
	<div class="element-select">
		<label class="title">Equipements spéciaux</label>
			<div class="item-cont">
				<div class="large">
					<span>
						<select name="equipement" >

						<option value="Kit Hydraulique">Kit Hydraulique</option>
						<option value="Godet">Godet</option>
						</select>
							<i></i>
								<span class="icon-place"></span>
					</span>
				</div>
			</div>
	</div>
	
	<div class="element-textarea">
		<label class="title"></label>
			<div class="item-cont">
				<textarea class="small" name="commentaire" cols="20" rows="5" placeholder="Commentaires "></textarea>
					<span class="icon-place"></span>
			</div>
	</div>
	
	<div class="element-select">
		<label class="title">
			<span class="required">* Affectation </span>
		</label>
			<div class="item-cont">
				<div class="large">
					<span>
						<select name="affectation" required="required">

						<option value="site 1">site 1</option>
						<option value="site 2">site 2</option>
						<option value="site 3">site 3</option>
		
						</select>
							<i></i>
								<span class="icon-place"></span>
					</span>
					</div>
			</div>
	</div>
	
	<div class="element-checkbox">
		<label class="title">Etat</label>		
			<div class="column column3">
				<label>
					<input type="checkbox" name="etat" value="Hors Parc "/ >
						<span>Hors Parc </span>
				</label>
			</div>
			<span class="clearfix"></span>
		<div class="column column3">
			<label>
				<input type="checkbox" name="etat" value="Reforme "/ >
					<span>Réformé </span>
			</label>
		</div>
			<span class="clearfix"></span>
			
		<div class="column column3">
			<label>
				<input type="checkbox" name="etat" value="Vendu"/ >
					<span>Vendu</span>
			</label>
		</div>
			<span class="clearfix"></span>
	</div>
	
	<div class="submit"><input type="submit" value="Enregistrer"/></div></form>
=======
	<div class="element-select"><label class="title"><span class="required">* Genre</span></label><div class="item-cont"><div class="large"><span><select name="genre" required="required">

		<option value="Vehicule Particulier">Véhicule Particulier</option>
		<option value="Camionnette de PTAC < ou = 3,5 tonnes">Camionnette de PTAC < ou = 3,5 tonnes</option>
		<option value="Tricycle ">Tricycle </option>
		<option value="Quadricycle ">Quadricycle </option>
		<option value="Vehicule utilitaire">Véhicule utilitaire</option>
		<option value="Moto ">Moto </option>
		<option value="Tracteur routier">Tracteur routier</option>
		<option value="Transport en commun de personne">Transport en commun de personne</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-select"><label class="title"><span class="required">* Catégorie</span></label><div class="item-cont"><div class="large"><span><select name="categorie" required="required">

		<option value="Vehicules legers">Véhicules légers</option>
		<option value="Vehicules intermediaires">Véhicules intermédiaires</option>
		<option value="Poids lourds et autocars a 2 essieux">Poids lourds et autocars à 2 essieux</option>
		<option value="Poids lourds et autocars a 3 essieux et plus">Poids lourds et autocars à 3 essieux et plus</option>
		<option value="Moto">Moto</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-select"><label class="title"><span class="required">* Carburant</span></label><div class="item-cont"><div class="large"><span><select name="energie" required="required">

		<option value="Essence">Essence</option>
		<option value="Diesel">Diesel</option>
		<option value="GPL">GPL</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-input" title="numero de serie"><label class="title"><span class="required">*Numéro de série</span></label><div class="item-cont"><input class="large" type="text" name="numerodeserie" required="required" placeholder="Numéro de série"/><span class="icon-place"></span></div></div>
	<div class="element-date" title="date"><label class="title"><span class="required">* Date</span></label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="date" required="required" placeholder=" Date"/><span class="icon-place"></span></div></div>
	<div class="element-input" title="matricule"><label class="title"><span class="required">* Matricule</span></label><div class="item-cont"><input class="large" type="text" name="matricule" required="required" placeholder="Matricule"/><span class="icon-place"></span></div></div>
	<div class="element-date" title="dateachat"><label class="title"><span class="required">*</span></label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="dateachat" required="required" placeholder="Date d’Achat
"/><span class="icon-place"></span></div></div>
	<div class="element-date" title="misecirculation"><label class="title"></label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="misecirculation" placeholder="Date de Mise en Route
"/><span class="icon-place"></span></div></div>
	<div class="element-input"><label class="title"><span class="required">* Compteur</span></label><div class="item-cont"><input class="large" type="text" name="kilometrage" required="required" placeholder="Compteur "/><span class="icon-place"></span></div></div>
	<div class="element-select"><label class="title">Equipements spéciaux</label><div class="item-cont"><div class="large"><span>
	
	<select name="equipement" >

		<option value="Kit Hydraulique">Kit Hydraulique</option>
		<option value="Godet">Godet</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-textarea"><label class="title"></label><div class="item-cont"><textarea class="small" name="commentaire" cols="20" rows="5" placeholder="Commentaires "></textarea><span class="icon-place"></span></div></div>
	<div class="element-select"><label class="title"><span class="required">* Affectation </span></label><div class="item-cont"><div class="large"><span><select name="affectation" required="required">

		<option value="site 1">site 1</option>
		<option value="site 2">site 2</option>
		<option value="site 3">site 3</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-checkbox"><label class="title">Etat</label>		<div class="column column3"><label><input type="checkbox" name="etat" value="Hors Parc "/ ><span>Hors Parc </span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="checkbox" name="etat" value="Reforme "/ ><span>Réformé </span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="checkbox" name="etat" value="Vendu"/ ><span>Vendu</span></label></div><span class="clearfix"></span>
</div>
<div class="submit"><input type="submit" value="Enregistrer"/></div></form>
>>>>>>> origin/master
<!-- Stop Formoid form-->



</body>
</html>