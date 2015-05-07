<?php
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
         
        
         
      </script>
	  
	  <script>
		$(function getAllproducts(){
		var lien_css = document.createElement('link');
		lien_css.setAttribute("href","../../css/DataTable/demo_page.css");
		lien_css.setAttribute("rel","stylesheet");
		lien_css.setAttribute("type","text/css");
		document.getElementsByTagName("head").item(0).appendChild(lien_css);

		   	$.ajax({
				method: 	"GET",
				url:		"http://think-parc.com/webservice/v1/companies/stocks/allproducts",  
				success:	function(data) {
								var response = JSON.parse(data);
								//var content = '<table id="example"><thead><tr><th>Marque</th><th>Modele</th><th>Mise en circulation</th><th>Kilometrage</th><th>Energie</th><th>Genre</th><th>Categorie</th><th>Num serie</th><th>Date achat</th><th>Date</th><th>Equipement</th><th>Commentaire</th><th>Etat</th><th>Matriculation</th><th>Affectation</th></tr></thead>';
								for (var i = 0; i<response.length; i++) 
								{
								content = '<table id="example">';
								content += '<thead>';
								content +='<tr>';
								content +='<th>Reference</th>';
								content +='<th>Designation</th>';
								content +='<th>Price</th>';
								content +='<th>Company</th>';
								content +='<th>family</th>';
								content +='<th>Quanty</th>';
								content +='<th>Measurement</th>';
								content +='<th>Driveway</th>';
								content +='<th>Bay</th>';
								content +='<th>Position</th>';
								content +='<th>Rack</th>';
								content +='<th>Site</th>';
								content +='<th>locker</th>';
								content +='</tr>';
								content +='</thead>';
								content +='<tr>';
								content +=  '<td><b>'+ response[i].reference +'</b></td>' + '<td><b>'+ response[i].designation +'</b></td>'
								+ '<td><b>'+ response[i].buyingprice + '' + response[i].currency +'</b></td>' 
								+ '<td><b>'+ response[i].company +'</b></td>' + '<td><b>'+ response[i].family +'</b></td>'
								+ '<td><b>'+ response[i].quanty + '' + response[i].measurement +'s</b></td>'
								+ '<td><b>'+ response[i].driveway +'</b></td>' + '<td><b>'+ response[i].bay +'</b></td>'
								+ '<td><b>'+ response[i].position +'</b></td>' + '<td><b>'+ response[i].rack +'</b></td>'
								+ '<td><b>'+ response[i].site +'</b></td>' + '<td><b>'+ response[i].typestock +'</b></td>'
								+ '<td><b>'+ response[i].locker +'</b></td> </table>';
								}
								document.getElementById("AllproductContent").innerHTML = content;
							}
			});
		});
	  </script>
      <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
   </head>
   <body background="../../images/bleu.png">
      <?php include('../header/navbar.php'); ?>
      <center>
         <h2>Informations vehicules</h2>
         <div class="element-select">
            <div class="item-cont">
               <div class="large">
                  <span>
                    
                        <h5>Liste de produits</h5>
                        
                     <span class="icon-place"></span>
                  </span>
               </div>
            </div>
         </div>
      </center>
      <div class="table-responsive">

            	<div id="AllproductContent"></div>
        
      </div>
   </body>
</html>