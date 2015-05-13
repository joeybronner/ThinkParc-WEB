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

        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/jquery.dataTables.js"></script>	  
	    <script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	

		<script type="text/javascript">
		
		
			$(function onLoad() {
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				document.getElementById("productblock").style.display = "none";
				getSites(id_company);
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
			
			
			

			
			
			function getsiteproduct(id_site) {
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/siteproduct/"+id_site, 
			success:	function(data) {
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							
							for (var i = 0; i<response.length; i++) 
							{
								dataSet[i] = new Array(	response[i].reference, 
														response[i].designation, 
														response[i].buyingprice, 
														response[i].currency, 
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
							//console.log(dataSet);
							
							
							document.getElementById("productblock").style.display = "block";
							
							$('#stock').html( '<table class="display" id="example"></table>' );
							
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
	};	 
							
         
 
		</script>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Consultation des stocks</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<table class="table-no-border">
										<tr>
											<td><h5>Veuillez sélectionner un site</h5></td>
										</tr>
										<tr>
											<td>
												<select id="listproducts" name="listproducts" class="form-control" onchange="getsiteproduct(this.value);">
													<!-- Retrieve all products with an AJAX [GET] query -->
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
			
			<!-- Retrieve products details with an AJAX [GET] query -->
				<div id="stock">
				</div>				
		</div>
   </body>
</html>