<?php
    	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/stocks/consultationproduct.fr.php');
	else
		include('../../lang/stocks/consultationproduct.en.php');
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
				getSites(id_company);
			});
			
			
			function getSites(id_company){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/sites", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['SITELIST'];?></option>';
								content = content + '<option value="0"><?php echo $stocks['ALLSITES'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						
								document.getElementById("listproducts").innerHTML = content;
         					}
         	});
         };
			
			
			function getsiteproduct(id_site, id_company) {
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/siteproduct/"+id_site+"/company/"+id_company, 
			success:	function(data) {
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							
							for (var i = 0; i<response.length; i++) 
							{
							
								if ( response[i].quanty == 0 )
									{
										var quanty = "Rupture de stock";
									} else {
									
										var quanty = response[i].quanty + " " + response[i].measurement + "(s)";
									}
									
								dataSet[i] = new Array(	response[i].reference, 
														response[i].designation, 
														response[i].buyingprice + response[i].currency, 
														response[i].company,
														response[i].family,
														quanty,
														response[i].driveway,
														response[i].bay,
														response[i].position,
														response[i].rack,
														response[i].site,
														response[i].typestock,
														response[i].locker);
							}
						
							document.getElementById("productblock").style.display = "block";
							
							$('#stock').html( '<table cellspacing="0" width="100%" id="example"></table>' );
							
							$('#example').dataTable( {
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
									{ "title": "<?php echo $stocks['REFERENCE'];?>" , "class": "center fctbw"},
									{ "title": "<?php echo $stocks['DES'];?>" , "class": "center fctbw"},
									{ "title": "<?php echo $stocks['PRICE'];?>" , "class": "center fctbw" },
									{ "title": "<?php echo $stocks['COMP'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['FAM'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['QUANTY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['BAY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['DRIVE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['POS'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['RACK'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['SITE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['TYPE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['LOCKER'];?>", "class": "center fctbw" }
								]
							} );   
						},
			error:		function(data) {
							
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
													<td><h5><?php echo $stocks['SELECT'];?></h5></td>
												</tr>
												<tr>
													<td>
													<script>
														var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
													</script>
														<select id="listproducts" name="listproducts" class="form-control" onchange="getsiteproduct(this.value, id_company);">
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
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2><?php echo $stocks['PRODUCT'];?></h2>
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
	<?php include('../footer/footer.php'); ?>
   </body>
</html>