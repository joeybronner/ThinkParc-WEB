<?php
include('./maclasse.php');
include('./MySQLExeption.php');
include('./connexion.php');

session_start();
if ((!isset($_SESSION['login'])) && (!empty($_SESSION['login'])))
	{
	
	exit("<center><h2>Acces interdit ! Veuillez vous authentifier</h2><br><br><a href='index.php'>Se connecter</a></center> ");
	}


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>FCT</title>

<link href="default.css" rel="stylesheet" type="text/css" media="screen" />

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


</script>
<style type="text/css" title="currentStyle">
			@import "../css/demo_page.css"; 
			@import "../css/demo_table.css";

</style>

<script type="text/javascript"><!--//--><![CDATA[//><!--
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
//--><!]]></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="./resources/demos/style.css">

		
 <link href='http://fonts.googleapis.com/css?family=Raleway:400,600,500,300,700' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/templatemo_main.css">

    </head>
    <body>

	<?php
	
		include('./navbar.html');
	?>

		
        <div id="main-wrapper">
<center>

</form> </p>

<!-- end menu -->
			
		<br/><br/>
 
	

	
	<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">   
   <thead> <!-- En-tÃªte du tableau -->
       <tr>
           <th>Date d'achat</th>
		   <th>Fournisseur</th>
		   <th>Dernier controle</th>
		   <th>Prochain controle</th>
		   <th>Numero contrat assurance</th>
		     <th>Assureur</th>
		   <th>Echeance du contrat</th>
		   <th>Conducteur(s)</th>
		 
		   
		  
          
       </tr>
   </thead>

   

    <?php 
		$dbh = new maclasse();
	foreach ($dbh->getvehiculee() as $Valeur)
    {
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
				  
		   		</tr>
    <?php
    }

?>
</table>
</div>
		
	
	
		
<!-- end footer -->
</body>
</html>
