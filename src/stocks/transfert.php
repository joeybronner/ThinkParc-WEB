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
		<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/jquery.backstretch.min.js"></script>
		<script src="../../js/templatemo_script.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script src="../../js/jquery.toast.js"></script>
		
	    <link rel="stylesheet" href="../../css/DataTable/jquery.dataTables_themeroller.css">
	    <link rel="stylesheet" href="../../css/DataTable/jquery.dataTables.min.css">
	    <link rel="stylesheet" href="../../css/DataTable/jquery.dataTables.css">
		<link rel="stylesheet" href="../../css/DataTable/jquery.dataTables_themefct.css">

        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/jquery.dataTables.js"></script>	  
	    <script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	

		<script type="text/javascript">
		
		
			$(function onLoad() {
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				document.getElementById("productblock").style.display = "none";
				document.getElementById("stock").style.display = "none";
				getSites(id_company);
				getsiteproduct(id_company);
				//getprodref(id_company);
			});
			
			
			
		
		

			
			function getSites(id_company){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/sites", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled>Liste des sites</option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						
								document.getElementById("listproducts").innerHTML = content;
								
         					}
         	});
         };
		 
		 	
			function getSites2(id_site){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				

		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/site/"+id_site+"/sites2", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled>Liste des sites</option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						
								document.getElementById("listproducts2").innerHTML = content;
         					}
         	});
         };
			
			
				function getprodref(id_site, id_company) {
				
				var id_site = document.getElementById('listproducts').value;
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_site+"/ref/"+id_company+"/company", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled>référence</option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].reference+'">'+ response[i].reference +'</option>';
         						}
         						
								document.getElementById("listref").innerHTML = content;
								
         					}
         	});
         };
			

			
			
			function getsiteproduct(id_company) {
				
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/sites", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled>Liste des sites</option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						
								document.getElementById("listproducts2").innerHTML = content;
								
         					}
         	});
         };
		 
		 
			function getblock() {
								
				document.getElementById("productblock").style.display = "block";
				document.getElementById("stock").style.display = "block";
			};
			
			
							
         function getnbproduct(id_stock){
				
				var id_site = document.getElementById('listproducts').value;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/nbproduct/"+id_stock,  
         		success:	function(data) {
         						var response = JSON.parse(data);
         						
         						var content =  '<h5>'+ response.total +'</h5>';
         						
         						document.getElementById("nbproduct").innerHTML = content;
         					}
         	});
         };
		 
		 	 
		 function getsiteproductbyref(ref, id_site, id_company) {
		 
		 getblock();
		 
			var ref = document.getElementById('listref').value;
			var id_site = document.getElementById('listproducts').value;
			var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/siteproductbyref/"+ref+"/site/"+id_site+"/company/"+id_company, 
			success:	function(data) {
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							var transfert = '<input type="text" name="quantytransfert"  class="small"></input> <input type="checkbox" name="selection"></input>';
							
							for (var i = 0; i<response.length; i++) 
							{
								dataSet[i] = new Array(	response[i].reference, 
														response[i].designation, 
														response[i].buyingprice + response[i].currency, 
														response[i].family,
														response[i].quanty + " " + response[i].measurement + "(s)",
														response[i].driveway,
														response[i].bay,
														response[i].position,
														response[i].rack,
														response[i].site,
														response[i].locker,
														transfert);
							}
							//console.log(dataSet);
							
							
							document.getElementById("productblock").style.display = "block";
							
							$('#stock').html( '<table class="display" cellspacing="0" width="100%" id="example"></table>' );
							
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
									{ "title": "reference" , "class": "center fctbw" },
									{ "title": "designation" , "class": "center fctbw"},
									{ "title": "buyingprice" , "class": "center fctbw" },
									{ "title": "family", "class": "center fctbw" },
									{ "title": "quanty", "class": "center fctbw" },
									{ "title": "driveway", "class": "center fctbw" },
									{ "title": "bay", "class": "center fctbw" },
									{ "title": "position", "class": "center fctbw" },
									{ "title": "rack", "class": "center fctbw" },
									{ "title": "site", "class": "center fctbw" },
									{ "title": "locker", "class": "center fctbw" },
									{ "title": "Transfert", "class": "center" }
								]
							} );   
						},
			error:		function(data) {
							//alert('error');
						}
		});
	};	 
								
         
		 
 
		</script>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Choix du produit à transferer</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<table class="table-no-border">
										<tr>
											<td><h5>Sélectionner le site A</h5></td>
										</tr>
										<tr>
											<td>
											
												<select id="listproducts" name="listproducts" class="form-control" onchange="getSites2(this.value);">
													<!-- Retrieve all products with an AJAX [GET] query -->
												</select>
											</td>
											
										</tr>
										<tr>
											<td><h5>Sélectionner le site B</h5></td>
										</tr>
										<tr>
											<td>
											<select id="listproducts2" class="form-control" onchange="getprodref(this.value);">
												<!-- Retrieve  with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>Sélectionner la reference</h5></td>
										</tr>
										<tr>
											<td>
											<select id="listref" name="listref" class="form-control" onchange="getsiteproductbyref(this.value, document.getElementById('listproducts').value)">
												<!-- Retrieve  with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										
										
									</table>
								</form>
							</div>
						</div>
					</div>
					
				</div>
			
			</div>
		</div>
			
			
				<div id="productblock">
				
			
			
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Transfert</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12">
										<div id="stock">
									    </div>	
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			
		</div>
		
	
			
   </body>
</html>