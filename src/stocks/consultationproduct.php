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
	   <link rel="stylesheet" href="DataTables/media/css/jquery.dataTables_themeroller.css">
	   <link rel="stylesheet" href="DataTables/media/css/jquery.dataTables.min.css">
	   <link rel="stylesheet" href="DataTables/media/css/jquery.dataTables.css">

      <script type="text/javascript" src="DataTables/media/js/jquery.js"></script>
      <script type="text/javascript" src="DataTables/media/js/jquery.dataTables.js"></script>	  
	  <script type="text/javascript" src="DataTables/media/js/jquery.dataTables.min.js"></script>	  

<script type="text/javascript">
	$(function test() {
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/allproducts", 
			success:	function(data) {
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							
							for (var i = 0; i<response.length; i++) 
							{
								dataSet[i] = new Array(	response[i].reference, 
														response[i].designation, 
														response[i].buyingprice + response[i].currency, 
														response[i].company,
														response[i].family,
														response[i].quanty,
														response[i].measurement,
														response[i].driveway,
														response[i].bay,
														response[i].position,
														response[i].rack,
														response[i].site,
														response[i].typestock,
														response[i].locker);
							}
							console.log(dataSet);
							
							$('#stock').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"></table>' );
							
							$('#example').dataTable( {
								"data": dataSet,
								   "bPaginate": true,
								   "bLengthChange": true,
								   "bStateSave": true,
								   "bFilter": true,
								   "bSort": true,
								   "bInfo": true,
								   "bAutoWidth": true,
								"columns": [
									{ "title": "reference" , "class": "center" },
									{ "title": "designation" , "class": "center"},
									{ "title": "buyingprice" , "class": "center" },
									{ "title": "company", "class": "center" },
									{ "title": "family", "class": "center" },
									{ "title": "quanty", "class": "center" },
									{ "title": "measurement", "class": "center" },
									{ "title": "driveway", "class": "center" },
									{ "title": "bay", "class": "center" },
									{ "title": "position", "class": "center" },
									{ "title": "rack", "class": "center" },
									{ "title": "site", "class": "center" },
									{ "title": "typestock", "class": "center" },
									{ "title": "locker", "class": "center" }
								]
							} );   
						},
			error:		function(data) {
							//alert('error');
						}
		});
	});
</script>

    
   </head>
   <body background="../../images/bleu.png">
   <?php 
         include('../header/navbar.php');
         ?>
   
		<div id="stock">
		</div>
   </body>
</html>