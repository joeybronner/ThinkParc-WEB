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
	  
	  <script>
		$(function getFamily(){
		   	$.ajax({
				method: 	"GET",
				url:		"http://think-parc.com/webservice/v1/companies/vehicles/all",  
				success:	function(data) {
								var response = JSON.parse(data);
								content = '<table id="example">';
								content += '<thead>';
								content +='<tr>';
								content +='<th>Marque</th>';
								content +='<th>Modele</th>';
								content +='<th>Mise en circulation</th>';
								content +='<th>Kilometrage</th>';
								content +='<th>Energie</th>';
								content +='<th>Genre</th>';
								content +='<th>Categorie</th>';
								content +='<th>Num serie</th>';
								content +='<th>Date achat</th>';
								content +='<th>Date</th>';
								content +='<th>Equipement</th>';
								content +='<th>Commentaire</th>';
								content +='<th>Etat</th>';
								content +='<th>Matriculation</th>';
								content +='<th>Affectation</th>';
								content +='</tr>';
								content +='</thead>';
								content +='<tr>';
								for (var i = 0; i<response.length; i++) 
								{
								content +=  '<td><b>'+ response[i].nr_plate +'</b></td>' + '<td><b>'+ response[i].nr_serial +'</b></td>'
								+ '<td><b>'+ response[i].mileage +'</b></td>' + '<td><b>'+ response[i].buyingprice +'</b></td>' 
								+ '<td><b>'+ response[i].date_buy +'</b></td>' + '<td><b>'+ response[i].date_add +'</b></td>';
								}
								content += '</tr></table>';
								document.getElementById("VehiclesContent").innerHTML = content;
							}
			});
		});
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
			<div id="VehiclesContent"></div>
               
        
		 
            </form>
      </div>
   </body>
</html>