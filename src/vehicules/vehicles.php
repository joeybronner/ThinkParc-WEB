<?php
   session_start();
?>
<html>
	<head>
		<title>Véhicules</title>
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
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/jquery.dataTables.js"></script>	  
	    <script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	
		<script type="text/javascript">
			$(function onLoad() {
				displayVehicles();
			});
			function getCompany(handleData){
				var id_user = <?php echo $_SESSION['fct_id_user']; ?>;
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/users/" + id_user,  
					success:	function(data) {
									var response = JSON.parse(data);
									handleData(response[0].id_company);
								}
				});
			};
			function displayVehicles() {
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all", 
						success:	function(data) {
										var response = JSON.parse(data);
										var dataSet = new Array(response.length);
										for (var i = 0; i<response.length; i++) {
											dataSet[i] = new Array(	response[i].nr_plate, 
																	response[i].nr_serial, 
																	response[i].mileage, 
																	response[i].buyingprice,
																	response[i].energy,
																	response[i].brand,
																	response[i].model,
																	response[i].kind,
																	response[i].category,
																	response[i].equipment,
																	response[i].state,
																	response[i].name,
																	response[i].commentary,
																	'<a href="javascript:deleteVehicle(' + response[i].id_vehicle + ');"><i id="icon_remove" class="fa fa-times"></i></a>');
										}
										
										$('#vehicles').html( '<table class="display" cellspacing="0" width="100%" id="example"></table>' );
							
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
												{ "title": "Immatriculation" , "class": "center fctbw" },
												{ "title": "N° de série" , "class": "center fctbw"},
												{ "title": "Kilométrage" , "class": "center fctbw" },
												{ "title": "Prix d'achat", "class": "center fctbw" },
												{ "title": "Carburant", "class": "center fctbw" },
												{ "title": "Marque", "class": "center fctbw" },
												{ "title": "Modèle", "class": "center fctbw" },
												{ "title": "Type", "class": "center fctbw" },
												{ "title": "Catégorie", "class": "center fctbw" },
												{ "title": "Equipement", "class": "center fctbw" },
												{ "title": "Etat", "class": "center fctbw" },
												{ "title": "Site", "class": "center fctbw" },
												{ "title": "Commentaire", "class": "center fctbw" },
												{ "title": "", "class": "center fctbw" }
											]
										} );
									}
					});				
				});
			}
			function deleteVehicle(id_vehicle) {
					$.ajax({
					method: 	"DELETE",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/" + id_vehicle,
					success:	function(data) {
										$(document).ready(function() {
											displayVehicles()
										});	
									}
					});
			}
		</script>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Recherche globale</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12">
										<div id="vehicles">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   </body>
</html>