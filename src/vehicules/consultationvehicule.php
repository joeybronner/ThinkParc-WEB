<?php
   include('../../db/db_functions.php');
   session_start();
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
      <link rel="stylesheet" href="../../css/DataTable/demo_page.css">
      <link rel="stylesheet" href="../../css/DataTable/jquery.dataTables.css">
      <link rel="stylesheet" href="../../css/DataTable/demo_table.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
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
      <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      <script>
         var selectValue = document.getElementById('matricule').options[document.getElementById('matricule').selectedIndex].value;
      </script>
   </head>
   <body background="../../images/bleu.png">
      <?php include('../header/navbar.php'); ?>
      <center>
         <h2>Informations vehicules</h2>
         <div class="element-select">
            <div class="item-cont">
               <div class="large">
                  <span>
                     <form method="GET" action="consultationadministratif.php">
                        <h5>Selectionner un matricule</h5>
                        <select name="id" class="large">
                           <option selected disabled>Liste vehicule</option>
                           <?php 
                              $dbh = new db_functions();
                              foreach ($dbh->getimmatriculationenregistre() as $Val) {
                              ?>
                           <option value="<?php echo $Val['id'];?>"><?php echo $Val['matricule'];?></option>
                           <?php
                              }
                              ?>  
                        </select>
                        <input TYPE="submit" name="submit" value="Voir ses informations administratif" />
                     </form>
                     <span class="icon-place"></span>
                  </span>
               </div>
            </div>
         </div>
      </center>
      <div class="table-responsive">
         <table id="example">
            <thead>
               <!-- En-tÃªte du tableau -->
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
               $dbh = new db_functions();
               foreach ($dbh->getvehicule() as $Valeur) {
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
            </form>
         </table>
      </div>
   </body>
</html>