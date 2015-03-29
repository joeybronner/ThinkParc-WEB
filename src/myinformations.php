<?php
include('./maclasse.php');
include('./MySQLExeption.php');
session_start();

if ((!isset($_SESSION['fct_login'])) && (!empty($_SESSION['fct_login']))) {
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
      "bAutoWidth": false
    } );
  } );
  </script>
  <style type="text/css" title="currentStyle">
  @import "../css/demo_page.css"; 
  @import "../css/demo_table.css";
  </style>

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


    <table id="example" class="display" width="100%">

     <thead> <!-- En-tÃªte du tableau -->
       <tr>
         <th>id</th>
         <th>nom</th>
         <th>prenom</th>
         <th>login</th>
         <th>image</th>
       </tr>
     </thead>

     <?php 
     $dbh = new maclasse();
     foreach ($dbh->getinfouser() as $Valeur)
     {
       ?>

       <tr>
         <td><b><?php echo $Valeur['id'];?></b></td>
         <td><b><?php echo $Valeur['Nom'];?></b></td>
         <td><b><?php echo $Valeur['Prenom'];?></b></td>
         <td><b><?php echo $Valeur['Login'];?></b></td>
         <td><img src="../images/<?php echo $Valeur['image']; ?>"/></td>
       </tr>
       <?php
     }

     ?>
   </table>
 </div>

 <br /><br /><br />


 <link rel="stylesheet" href="../css/formul_files/formoid1/formoid-flat-green.css" type="text/css" />
 <form action="Enregistrementlogo.php" enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#dcd5d6;font-size:14px;font-family:'Lato', sans-serif;color:#313131;max-width:480px;min-width:150px" method="get"><div class="title"><h2>Changer/Ajouter logo</h2></div>

  <div class="element-file"><label class="title">Logo</label><label class="large" ><div class="button">Choisir un fichier</div><input type="file" class="file_input" name="logo" /><div class="file_text">Parcourir mes fichiers</div></label></div>
  <div class="submit"><input type="submit" value="Envoyer" /></div></form><p class="frmd"><script type="text/javascript" src="formul_files/formoid1/formoid-flat-green.js"></script>
  <!-- Stop Formoid form-->

  <!-- end footer -->
</body>
</html>
