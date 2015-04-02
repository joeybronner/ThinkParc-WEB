<?php
include('./maclasse.php');
include('./MySQLExeption.php');
session_start();
if ((!isset($_SESSION['login'])) && (!empty($_SESSION['login'])))
	{
	
	exit("<center><h2>Acces interdit ! Veuillez vous authentifier</h2><br><br><a href='index.php'>Se connecter</a></center> ");
	}


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>FCT</title>

    <script type="text/javascript" src="../js/jquery.js"></script>
	 <script type="text/javascript" src="../js/jquery.dataTables.js"></script>

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



<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


		
 <link href='http://fonts.googleapis.com/css?family=Raleway:400,600,500,300,700' rel='stylesheet' type='text/css'>
        
           <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">



    </head>
    <body>

	<?php
	
		include('./navbar.html');
	?>
 
		
<form class="formoid-solid-dark"  method="get">
<center>

</form> </p>

<!-- end menu -->
		 <center><h2>Informations vehicules</h2></center>
		<br/><br/>
 
	
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
		   
		  
          
       </tr>
   </thead>

   

    <?php 
		$dbh = new maclasse();
	foreach ($dbh->getvehicule() as $Valeur)
    {
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
		   		</tr>
    <?php
    }

?>
</table>
</div>



<br /><br /><br />
			<div class="element-select"><label class="title">Selectionner un matricule</label><div class="item-cont"><div class="large"><span><select name="matricule" >
				<option selected disabled>Liste vehicule</option>
			<?php 
		$dbh = new maclasse();
	foreach ($dbh->getimmatriculationenregistre() as $Val)
    {
	?>
	
		<option value="<?php echo $Val['id'];?>"><?php echo $Val['matricule'];?></option>
		
	<?php
		
		
	
	}
	
	$monid = $Val['id'];
	echo $monid;
	?>
      <script>
	  //var selectValue = getSelectValue('matricule');
	  var selectValue = document.getElementById('matricule').options[document.getElementById('matricule').selectedIndex].value;

	 </script>
		
		</select><i></i><span class="icon-place"></span></span></div></div></div>
		<br /><br />
		 <center><a href="consultationadministratif.php?id="<?php echo $monid;?>/"><b><input type="button" name="Administratif" value="Voir ses informations administratif"></b></a></center>
</form>

<!-- end footer -->
</body>
</html>
