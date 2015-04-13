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
					"bPaginate": false,
					"bLengthChange": false,
					"bStateSave": true,
					"bFilter": false,
					"bSort": false,
					"bInfo": false,
					"bAutoWidth": false,
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

<?php include('../header/navbar.php'); ?>

	
<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed">   
	<thead>
		<tr>
			<th>Date d'achat</th>
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
		<form method="get" action="deleteadministratif.php">
    <?php 
		$dbh = new db_functions();
		foreach ($dbh->getvehiculee() as $Valeur) {
	?>
		<tr>
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
</body>
</html>
