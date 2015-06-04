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
		<link rel="stylesheet" href="../../css/DataTable/jquery.dataTables_themefct.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/jquery-ui.min.js"></script>
		<script src="../../js/jquery.backstretch.min.js"></script>
		<script src="../../js/templatemo_script.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script type="text/javascript" src="../../js/jquery.toast.js"></script>
		<script type="text/javascript" src="../../js/jquery.dataTables.js"></script>  
		<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	

		<script type="text/javascript">
			
			var idstock = [];
			var myref = [];
			var size;
			var total = 0;
			var test;
		
			$(function onLoad() 
			{
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				document.getElementById("productblock").style.display = "none";
				document.getElementById("stock").style.display = "none";
				getsiteproduct(id_company);
			});
			
			
			
			function getsiteproduct(id_company) 
			{
				

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
		 
		 
			function getblock() 
			{		
				document.getElementById("stock").style.display = "block";
			};
			
			
			function check()
			{
			
				var thesize = window.size;
				total = 0;
				
				var productnumber;
				//var ref = window.myref[i];
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				
				for (var i = 0; i < thesize; i++ )
				{
						var ref = window.myref[i];
						idstock = idstock[i];
						// Checkbox checked test
						if (document.getElementById('numcheckbox'+i).checked == true)
						{
							total++;
							productnumber = document.getElementById('productnumber'+i).value;
							TransfertProduct(ref, i, productnumber, idstock);
						}
							
				}
				
				
					//alert('Nombre de checkbox cochées : '+total);
					total = 0;
					getcompanyproduct(id_company);
			
			}
		 
		 
		 function TransfertProduct(ref, i, quanty, idstock) 
		 {
		 
			
				var productnumber = document.getElementById('productnumber'+i).value;
				//var id_site1 = document.getElementById('listproducts').value;
				var id_site2 = document.getElementById('listproducts2').value;
				//var ref = window.myref;
				//var id_site = document.getElementById('listproducts').value;
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		

				if (quanty < parseInt(productnumber))
				{
					alert('Nombre supérieur au nombre en stock ! quanty:' +quanty+ '- productnumber : '+productnumber);
					getcompanyproduct(id_company);
					return false;
				}	
				
				
				$.ajax({
					method: 	"POST",
					url:		"http://think-parc.com/webservice/v1/companies/stocks/ref/"+ref+"/quanty/"+productnumber+"/secondsite/"+id_site2+"/idstock/"+idstock,   
					success:	function() 
								{
									$.toast({heading: "Success",text: "Product(s) successfully transfered.", icon: "success"});
									//getsiteproductbyref(ref +','+ id_site +','+ id_company);
									getcompanyproduct(id_company);
								},
					error:		function() 
								{
									$.toast({heading: "Error",text: "Error", icon: "error"});
								}	
			});
		
		 }
		 
		   
		 function getcompanyproduct(id_company) 
		 {
		 
			getblock();
			
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/companyproduct/company/"+id_company, 
			success:	function(data) {
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							myref = new Array(response.length);
							//idstock = new Array(response.length);
							
							for (var i = 0; i<response.length; i++) 
							{
								idstock[i] = response[i].id_stock;
								
								if ( response[i].quanty == 0 )
									{
										var quanty = "Rupture de stock";
									} else {
									
										var quanty = response[i].quanty + " " + response[i].measurement + "(s)";
									}
									
									
									
									dataSet[i] = new Array(	response[i].reference,   
														quanty,
														response[i].driveway,
														response[i].bay,
														response[i].position,
														response[i].rack,
														response[i].locker,
														response[i].site,
														'<input type="text" id="productnumber'+i+'" class="small" placeholder="quantity"></input> <input type="checkbox" id="numcheckbox'+i+'"/>');
														
										size = i;
										myref[i] = response[i].id_part;
										test = '<input type="hidden" id="montest'+i+'" value="'+response[i].id_part+'">';
										
							
							}
							
							
							
							document.getElementById("productblock").style.display = "block";
							
							$('#stock').html( '<table  cellspacing="0" width="100%" id="example"></table>' );
							
							var table = $('#example').dataTable( {
								"data": dataSet,
								   "scrollX": true,
								   "bPaginate": true,
								   "bLengthChange": true,
								   "bStateSave": true,
								   "bFilter": true,
								   "bSort": true,
								   "bInfo": true,
								   "bAutoWidth": true,
								"columns": [
									{ "title": "reference" , "class": "center fctbw" },
									{ "title": "quanty", "class": "center fctbw" },
									{ "title": "driveway", "class": "center fctbw" },
									{ "title": "bay", "class": "center fctbw" },
									{ "title": "position", "class": "center fctbw" },
									{ "title": "rack", "class": "center fctbw" },
									{ "title": "locker", "class": "center fctbw" },
									{ "title": "site", "class": "center fctbw" },
									{ "title": "Transfer amount", "class": "small"}
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
											<td><h5>Sélectionner le site destinataire</h5></td>
										</tr>
										<tr>
											<td>
												<script>
													var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
												</script>
												<select id="listproducts2" class="form-control" onchange="getcompanyproduct(id_company);">
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
										<a href="javascript:check();">check</a>
									<input type="submit" value="Valider le transfert" onclick="check();" class="btn btn-success">&nbsp;<input type="reset" value="Reinitialiser" class="btn btn-warning"/>

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