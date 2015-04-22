<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
?>

<html>
<head>
    <head>
		<title>FCT Partners</title>
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
        <meta name="description" content="">
		<meta charset="utf-8">
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="stylesheet" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">
		
		<script type="text/javascript" src="../../js/jquery.js"></script>
	 <script type="text/javascript" src="../../js/jquery.dataTables.js"></script>

	<script type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable( {
        "bPaginate": true,
        "bLengthChange": true,
		"bStateSave": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
		
    } );
} );


				/**Retourne la valeur du select selectId*/
				function getSelectValue(selectId)
				{
					/**On récupère l'élement html <select>*/
					var selectElmt = document.getElementById(selectId);
					/**
					selectElmt.options correspond au tableau des balises <option> du select
					selectElmt.selectedIndex correspond à l'index du tableau options qui est actuellement sélectionné
					*/
					return selectElmt.options[selectElmt.selectedIndex].value;
				}

</script>

<style type="text/css" title="currentStyle">
			@import "../../css/DataTable/demo_page.css"; 
			@import "../../css/DataTable/jquery.dataTables.css";
			@import "../../css/DataTable/demo_table.css";

</style>

	</head>
<body background="../../images/bleu.png">


<?php include('../header/navbar.php'); ?>

	
<div class="table-responsive">
	<table id="example">   
	<thead>
		<tr>
			<th>Prix d'achat</th>
		    <th>Fournisseur</th>
		    <th>Dernier controle</th>
		    <th>Prochain controle</th>
		    <th>Numero contrat assurance</th>
			<th>Assureur</th>
		    <th>Echeance du contrat</th>
		    <th>Conducteur(s)</th>
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
		<form method="GET" action="deleteadministratif.php">
    <?php 
		$dbh = new db_functions();
		foreach ($dbh->getvehiculeadministratif() as $Valeur) {
	?>
		<tr>
			<input type="hidden" name="id" value="<?php $Valeur['id_vehicule'];?>">
	
			<td><b><?php echo $Valeur['prixachat'];?></b></td>
		    <td><b><?php echo $Valeur['fournisseur'];?></b></td>
		    <td><b><?php echo $Valeur['derniercontrole'];?></b></td>
			<td><b><?php echo $Valeur['prochaincontrole'];?></b></td>
			<td><b><?php echo $Valeur['numcontratassurance'];?></b></td>
			<td><b><?php echo $Valeur['nomassurance'];?></b></td>
			<td><b><?php echo $Valeur['echeanceassurance'];?></b></td>
			<td><b><?php echo $Valeur['conducteur'];?></b></td>	  
			<?php
				if ($_SESSION['fct_privilege'] =='admin')
				{
				?>
				
			<td><a href="deleteadministratif.php?id=<?php echo $Valeur['id'];?>" onclick="return(confirm('Etes-vous sur de vouloir supprimer cette fiche?'));"><button class="btn btn-danger" type="button" data-toggle="dropdown" aria-expanded="false">Supp</button></a></td>

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

<center><a href="consultationvehicule.php"><button class="btn .btn-link">Retour</button></a></center> 

</body>
</html>
