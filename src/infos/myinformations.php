<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();
?>

<html>
<head>
	<title>FCT</title>
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/templatemo_main.css">
	<link rel="stylesheet" href="../../css/app.css">
	<link rel="stylesheet" href="../../css/formul_files/formoid1/formoid-flat-green.css" type="text/css" />
	<script type="text/javascript" src="../../js/jquery.js"></script>
	  <script type="text/javascript">
	  $(document).ready(function() {  
		$('#example').dataTable( {
		  "bPaginate": false,
		  "bLengthChange": false,
		  "bStateSave": true,
		  "bFilter": false,
		  "bSort": false,
		  "bInfo": false,
		  "bAutoWidth": false
		} );
	  } );
	  </script>
	<script type="text/javascript">
	sfHover = function() {
		var sfEls = document.getElementById("nav").getElementsByTagName("li");
		for (var i=0; i<sfEls.length; i++) {
		  sfEls[i].onmouseover=function() {
		   this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
		  this.className=this.className.replace(new RegExp(" sfhover\b"), "");
		}
	  }
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);
	</script>
</head>
<body>
<?php
/*
$_FILES['icone']['name']     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$_FILES['icone']['type']     //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['icone']['size']     //La taille du fichier en octets.
$_FILES['icone']['tmp_name'] //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$_FILES['icone']['error']    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.*/
?>
	<?php include('../header/navbar.php'); ?>
	<div id="main-wrapper">
		<center>
		<table id="example" class="display" width="80%" border="1">
			<thead>
				<tr>
					<th>id</th>
					<th>nom</th>
					<th>prenom</th>
					<th>login</th>
					<th>image</th>
			   </tr>
			</thead>

			<?php 
				foreach ($dbh->getinfouser() as $Valeur)
				{
			?>
			<tr>
				<td><b><?php echo $Valeur['id'];?></b></td>
				<td><b><?php echo $Valeur['nom'];?></b></td>
				<td><b><?php echo $Valeur['prenom'];?></b></td>
				<td><b><?php echo $Valeur['login'];?></b></td>
				<!--<td><pre><?php  //print_r($_FILES); ?></td>-->
			</tr>
			<?php
				}
			?>
		</table>
			</center>
	</div>
	
	<center>
	<form action="enregistrementlogo.php" enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#dcd5d6;font-size:14px;font-family:'Lato', sans-serif;color:#313131;max-width:480px;min-width:150px" method="get">
		<div class="title">
			<h2>Changer/Ajouter logo</h2>
		</div>
		<div class="element-file">
			<label class="title">Logo</label>
			<label class="large">
				<div class="button">Choisir un fichier</div>
					<input type="file" class="file_input" name="file" />
				<div class="file_text">Parcourir mes fichiers</div>
			</label>
			<?php
			
	//Créer un dossier 'fichiers/1/'
	//mkdir('fichier/1/', 0777, true);
 
//Créer un identifiant difficile à deviner
  //$nom = md5(uniqid(rand(), true));
?>
		</div>
		<div class="submit">
			<input type="submit" value="Envoyer" />
		</div>
	</form>
	</center>
</body>
</html>
