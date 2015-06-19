<?php
     	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/stocks/transfert.fr.php');
	else
		include('../../lang/stocks/transfert.en.php');
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
		
			
			$(function onLoad() {
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				document.getElementById("productblock").style.display = "none";
				document.getElementById("stock").style.display = "none";
				getSites(id_company);
				getsiteproduct(id_company);
			});
			
			
			
			var idstock = [];
			var quanty = [];
			var myref = [];
			var type = [];
			var measure = [];
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
								var content = '<option selected disabled><?php echo $stocks['LIST'];?></option>';
								
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
				document.getElementById("productblock").style.display = "block";
				document.getElementById("stock").style.display = "block";
			};
			
			
			function check()
			{
			
				var thesize = window.size;
				var exec = false;
				var productnumber;
				var idsite = document.getElementById('listproducts').value;
				var title = document.getElementById('title').value;
				total = 0;
				
				
				if (title == "")
				 {
					title = "Sans titre";
				 }
				
				for (var i = 0; i <= thesize; i++ )
				{
						var ref = window.myref[i];
						var ids = idstock[i];
						var quantity = window.myquanty[i];
						var type = window.type[i];
						var measure = window.measure[i];
						productnumber = document.getElementById('productnumber'+i).value;
						
						if (productnumber > 0)
						{
							total++;
							TransfertProduct(ref, i, productnumber, ids, quantity, type, measure, title);
							exec = true;
						}
							
				}
				
					total = 0;
					
					if (exec)
					{
						getcompanyproduct(id_company, idsite);
					} else
					{
						$.toast({heading: "Error",text: "Error in the Check Ref", icon: "error"});
					}
			
			}
		 
		 
		 function TransfertProduct(ref, i, productnumber, idstock, quantity, type, measure, title) 
		 {
	
				var productnumber = document.getElementById('productnumber'+i).value;
				var id_site2 = document.getElementById('listproducts2').value;
				var idsite = document.getElementById('listproducts').value;
		
				if (quantity < parseInt(productnumber))
				{
					alert('<?php echo $stocks['ERROR'];?>');
					getcompanyproduct(id_company,idsite);
					return false;
				}
				
				$.ajax({
					method: 	"POST",
					url:		"http://think-parc.com/webservice/v1/companies/stocks/ref/"+ref+"/quanty/"+productnumber+"/secondsite/"+id_site2+"/idstock/"+idstock+"/type/"+type+"/measure/"+measure+"/title/"+title,   
					success:	function() 
								{
									$.toast({heading: "Success",text: "Product(s) successfully transfered.", icon: "success"});
									getcompanyproduct(id_company,idsite);
								},
					error:		function() 
								{
									$.toast({heading: "Error",text: "Error", icon: "error"});
								}	
			});
		
		 }
		 
		   
		 function getcompanyproduct(id_company,idsite)
		 {
			getblock();
			var idsite = document.getElementById('listproducts').value;
			var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
			
			
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/companyproduct/company/"+id_company+"/idsite/"+idsite, 
			success:	function(data) {
							
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							myref = new Array(response.length);
							myquanty = new Array(response.length);
							type = new Array(response.length);
							measure = new Array(response.length);
							
							for (var i = 0; i<response.length; i++) 
							{
								idstock[i] = response[i].id_stock;
								
								if ( response[i].quanty == 0 )
									{
										var quanty = "<?php echo $stocks['BREAK'];?>";
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
														'<input type="text" id="productnumber'+i+'" class="small" placeholder="quantity"></input>');
														
										size = i;
										myref[i] = response[i].id_part;
										myquanty[i] = response[i].quanty;
										type[i] = response[i].id_typestock;
										measure[i] = response[i].id_measurement;
										
										
							
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
									{ "title": "<?php echo $stocks['REFERENCE'];?>" , "class": "center fctbw" },
									{ "title": "<?php echo $stocks['QUANTY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['DRIVE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['BAY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['POSITION'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['RACK'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['LOCKER'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['SITE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['AMOUNT'];?>", "class": "center fctbw"}
								]
							} );   
						},
			error:		function(data) {
					
						}
		});
	};	 
		
		
			function getSites(id_company){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/sites", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['SITE'];?></option>';
								
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
								var content = '<option selected disabled><?php echo $stocks['SITE'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						
								document.getElementById("listproducts2").innerHTML = content;
         					}
         	});
         };
			
			
		</script>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners"/>
		
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		  <div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=products">
					<h5><i class="fa fa-chevron-left"></i><?php echo $stocks['BACK'];?></h5>
				</a>
			</div>
		  </div>
			<div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2><?php echo $stocks['TITLE'];?></h2>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-lg-12"> 
									<form>
										<table class="table-no-border">
											<tr>
												<td><h5><?php echo $stocks['SELECT1'];?></h5></td>
											</tr>
											<tr>
												<td>
												
													<select id="listproducts" name="listproducts" class="form-control" onchange="getSites2(this.value);">
														<!-- Retrieve all products with an AJAX [GET] query -->
													</select>
												</td>
												
											</tr>
											<tr>
												<td><h5><?php echo $stocks['SELECT2'];?></h5></td>
											</tr>
											<tr>
												<td>
												<script>
														var idsite = document.getElementById('listproducts').value;
														var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
													</script>
												<select id="listproducts2" class="form-control" onchange="getcompanyproduct(id_company, idsite);">
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
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=products">
					<h5><i class="fa fa-chevron-left"></i><?php echo $stocks['BACK'];?></h5>
				</a>
			</div>
		</div>
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2><?php echo $stocks['TRANSFER'];?></h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12">
											<div id="stock">
											</div>	
											<center><h4><?php echo $stocks['INPUT'];?></h4></center>
											<input type="text" id="title" placeholder="<?php echo $stocks['INPUTNAME'];?>" class="transfert-form"/>
											<br />
											<br />
											<a href="javascript:check();" class="btn btn-success"/><?php echo $stocks['SUBMIT'];?></a>&nbsp;<input type="reset" value="<?php echo $stocks['RESET'];?>" class="btn btn-warning"/>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('../footer/footer.php'); ?>	
   </body>
</html>