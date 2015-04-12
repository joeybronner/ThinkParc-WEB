<?php

require_once('../db/config.php'); 
include('./maclasse.php');
include('./MySQLExeption.php');

session_start();


?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Enregistrer un machine </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	     <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/templatemo_main.css">
		<link rel="stylesheet" href="../css/app.css">
		

<script type="text/javascript">
    function getval(sel) {
       alert(sel.value);
	   $liste=sel.value;
	   document.getElementById('liste').value;
    }

	</script>
	<script>
function recup_modele()
{
    // Récupere la données de la liste déroulante
    var recup_modele = document.getElementById("liste").value;
	alert(recup_modele);
    // Transmet la variable nomVille dans le input hidden de la page ajoutFrs.php
    //document.getElementById("select1").value=recup_ville;
}
	</script>
</head>
<body class="blurBg-true" style="background-color:#464646" onload="document.form.modele.onchange();">


	<?php
		
		include('./navbar.html');
	?>

<!-- Start Formoid form-->
<link rel="stylesheet" href="../css/formulairevehicule_files/formoid1/formoid-solid-dark.css" type="text/css" />
<script type="text/javascript" src="../css/formulairevehicule_files/formoid1/jquery.min.js"></script>
<form class="formoid-solid-dark" style="background-color:#7d7d7d;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#005500;max-width:480px;min-width:150px" method="get" action="EnregistrementVehicule.php"><div class="title"><h2>Enregistrer une machine</h2></div>
	
	<div class="element-select">
		<div class="item-cont">
			<span>
				<select name="marque" class="medium" >
						<option selected disabled>Marque de la machine</option>
				<?php 

					$dbh = new maclasse();
				foreach ($dbh->getvehiculemarque() as $Valeur)
				{
				
				?>
				
					<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['libelle'];?></option>
					
				<?php
				}
				?>
					</select></span><i></i><span class="icon-place"></span><span><select name="modele" class="medium" >
					<option selected disabled>Modèle de la machine</option>
			<?php 

		$dbh = new maclasse();
	foreach ($dbh->getvehiculemodele() as $Valeur)
    {
	
	?>
	
		<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['modele'];?></option>
		
	<?php
	}

	?>
		</select>
			</span>
				<i></i>
					<span class="icon-place"></span>
						</div>
							</div>
		
		<div class="element-select">
			<div class="item-cont">
				<span>
					<select name="genre" class="medium" >
						
						<option selected disabled>Genre</option>
						<option value="Vehicule Particulier">Véhicule Particulier</option>
						<option value="Camionnette de PTAC < ou = 3,5 tonnes">Camionnette de PTAC < ou = 3,5 tonnes</option>
						<option value="Tricycle ">Tricycle </option>
						<option value="Quadricycle ">Quadricycle </option>
						<option value="Vehicule utilitaire">Véhicule utilitaire</option>
						<option value="Moto ">Moto </option>
						<option value="Tracteur routier">Tracteur routier</option>
						<option value="Transport en commun de personne">Transport en commun de personne</option>
		</select>
			</span>
				<i></i>	
					<span class="icon-place"></span>
					
		<span>
			<select name="categorie" class="medium" >
				<option selected disabled>Catégorie</option>
				<option value="Vehicules legers">Véhicules légers</option>
				<option value="Vehicules intermediaires">Véhicules intermédiaires</option>
				<option value="Poids lourds et autocars a 2 essieux">Poids lourds et autocars à 2 essieux</option>
				<option value="Poids lourds et autocars a 3 essieux et plus">Poids lourds et autocars à 3 essieux et plus</option>
				<option value="Moto">Moto</option>
			</select>
		</span>
			<i></i>
				<span class="icon-place"></span>
					</div>
						</div>
		
	<div class="element-select">
		<label class="title">
			<span class="required">*</span>
		</label>	
		
			<div class="item-cont">
				<div class="large">
					<span>
						<select name="energie" required="required" class="medium">
	
							<option selected disabled>Energie</option>
							<option value="Essence">Essence</option>
							<option value="Diesel">Diesel</option>
							<option value="GPL">GPL</option></select><select name="equipement" class="medium">
							<option selected disabled>Equipements spéciaux</option>
							<option value="Kit Hydraulique">Kit Hydraulique</option>
							<option value="Godet">Godet</option>
						</select>
					<i></i>
					<span class="icon-place">
					
		</span></span>
		</div>
			</div>
				</div>
		
		
	<div class="element-date" title="date">
		<label class="title"><span class="required">* Date</span></label>
			<div class="item-cont">
				<input class="medium" data-format="yyyy-mm-dd" type="date" name="date" required="required" placeholder=" Date"/>
					<span class="icon-place"></span>
			</div>
		</div>
	
	<div class="element-input" title="matricule">
	<label class="title"></label>
		<div class="item-cont">
<input class="medium" type="text" name="matricule" placeholder="Matricule"/><input class="medium" type="text" name="numerodeserie" placeholder="Numéro de série"/>
		<span class="icon-place"></span>
		</div>
			</div>

	<div class="element-date">
		<label class="title">
			<span class="required">*</span>
				</label>
		<div class="item-cont">
<input class="medium" data-format="yyyy-mm-dd" type="date" name="dateachat" required="required" placeholder="Date d’Achat " /><input class="medium" data-format="yyyy-mm-dd" type="date" name="misecirculation" placeholder="Date de Mise en Route"/>    
	<span class="icon-place"></span>
		</div>
			</div>

	<div class="element-input">
		<label class="title">
			<span class="required">*</span>
		</label>
		<div class="item-cont">
	<input class="medium" type="text" name="kilometrage" required="required" placeholder="Compteur "/>
	<span class="icon-place">
		</span>
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
				<span class="required">*</span>
		</label>
		<div class="item-cont">
	<div class="medium">
	<span>
	<select name="affectation" required="required">
		<option selected disabled>Affectation</option>
		<option value="site 1">site 1</option>
		<option value="site 2">site 2</option>
		<option value="site 3">site 3</option></select><i></i><span class="icon-place"></span></span></div></div></div>
		<br />

		<div class="element-checkbox">	
		<label class="title">Etat</label>		
		<div class="column column3"><label><input type="checkbox" name="etat" value="Hors Parc "/><span>Hors Parc </span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="checkbox" name="etat" value="Reforme "/><span>Réformé </span></label></div><span class="clearfix"></span>
		<div class="column column3"><label><input type="checkbox" name="etat" value="Vendu"/><span>Vendu</span></label></div><span class="clearfix"></span>
</div>
<div class="submit"><input type="submit" value="Enregistrer"/></div></form>
<!-- Stop Formoid form-->



</body>
</html>