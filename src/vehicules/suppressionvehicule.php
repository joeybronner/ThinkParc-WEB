<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();
?>

<html>
	<head>
		<title>FCT Partners</title>
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
        <meta name="description" content="">
		<meta charset="utf-8">
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="stylesheet" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">

		<script>
			var selectValue = document.getElementById('matricule').options[document.getElementById('matricule').selectedIndex].value;
		</script>
	</head>
<body background="../../images/bleu.png">

	<?php include('../header/navbar.php'); ?>
	<center>
		<h3>Informations vehicules</h3>
		 <?php $count = $dbh->getnbCar() ?>
		<h2> <?php ECHO 'Nombre de véhicules : '.$count['total']; ?></h2>
	
	</center>
	<div class="table-responsive">
		
	<table class="table table-striped table-bordered table-condensed">   
		<thead> <!-- En-tÃªte du tableau -->
			<tr>
				<th>Marque</th> 
				<th>Modele</th>
			    <th>Mise en circulation</th>
			    <th>Kilometrage</th>
			    <th>Energie</th>
			    <th>Genre</th>
			    <th>Categorie</th>
				<th>Num serie</th>
			    <th>Date achat</th>
			    <th>Date</th>
			    <th>Equipement</th>
			    <th>Commentaire</th>
			    <th>Etat</th>
			    <th>Matriculation</th>
			    <th>Affectation</th>
				<?php
				if ($_SESSION['fct_privilege'] =='admin')
				{
				?>
				<th>Supp</th>
				<?php
				}
				?>
			</tr>
		</thead>
		<form method="get" action="deletevehicule.php">

    <?php 
		foreach ($dbh->getCar() as $Valeur) {
	?>
		<tr>
			<td><b><?php echo $Valeur['libelle'];?></b></td>
			<td><b><?php echo $Valeur['modele'];?></b></td>
            <td><b><?php echo $Valeur['misecirculation'];?></b></td>
		    <td><b><?php echo $Valeur['kilometrage'];?></b></td>
		    <td><b><?php echo $Valeur['energie'];?></b></td>
			<td><b><?php echo $Valeur['genre'];?></b></td>
			<td><b><?php echo $Valeur['categorie'];?></b></td>
			<td><b><?php echo $Valeur['numerodeserie'];?></b></td>
			<td><b><?php echo $Valeur['dateachat'];?></b></td>
			<td><b><?php echo $Valeur['date'];?></b></td>
			<td><b><?php echo $Valeur['equipement'];?></b></td>
			<td><b><?php echo $Valeur['commentaire'];?></b></td>
			<td><b><?php echo $Valeur['etat'];?></b></td>
			<td><b><?php echo $Valeur['matricule'];?></b></td>
			<td><b><?php echo $Valeur['affectation'];?></b></td>
			<?php
				if ($_SESSION['fct_privilege'] =='admin')
				{
				?>
				
			<td><a href="deletevehicule.php?id=<?php echo $Valeur['id'];?>" onclick="return(confirm('Etes-vous sur de vouloir supprimer ce vehicule?'));"><button class="btn btn-danger" type="button" data-toggle="dropdown" aria-expanded="false">Supp</button></a></td>

				<?php
				}
				?>
		</tr>
    <?php
		}
	?>
	</form>
</table>
</div>

</body>
</html>
