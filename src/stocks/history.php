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
				getreleaseproduct(id_company);
			});
			
			
			function getreleaseproduct(id_company){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/release", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled>Liste des sorties</option>';
								content = content + '<option value="all">Toutes les sorties</option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].title+'"> date : '+ response[i].transferdate +' --- libellé : '+ response[i].title +' </option>';
         						}
         						
								document.getElementById("list").innerHTML = content;
         					}
         	});
         };
			
			
			function gethistory(title, id_company) {
			
			var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
			
			$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/historylist/"+title+"/company/"+id_company, 
			success:	function(data) {
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							
							for (var i = 0; i<response.length; i++) 
							{
							
									
								dataSet[i] = new Array( response[i].title,  
														response[i].reference,
														response[i].companyname,
														response[i].quantity,
														response[i].transferdate,
														response[i].validationdate);
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
									{ "title": "Libelle" , "class": "center fctbw"},
									{ "title": "Produit" , "class": "center fctbw" },
									{ "title": "Destinataire", "class": "center fctbw" },
									{ "title": "Quantité", "class": "center fctbw" },
									{ "title": "Date de transfert", "class": "center fctbw" },
									{ "title": "Date de validation", "class": "center fctbw" }
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
					<h5><i class="fa fa-chevron-left"></i> Retour</h5>
				</a>
			</div>
		</div>
		   <div class="templatemo-content">
			    <div class="black-bg btn-menu margin-bottom-20">
					<h2>Consultation de l'historique des sorties</h2>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-lg-12"> 
									<form>
										<table class="table-no-border">
												<tr>
													<td><h5>Veuillez sélectionner une sortie</h5></td>
												</tr>
												<tr>
													<td>
													<script>
														var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
													</script>
														<select id="list" name="list" class="form-control" onchange="gethistory(this.value);">
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
					<h2>Historique</h2>
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