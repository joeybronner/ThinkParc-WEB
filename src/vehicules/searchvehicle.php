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
		<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/jquery.backstretch.min.js"></script>
		<script src="../../js/templatemo_script.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script src="../../js/jquery.toast.js"></script>
		<script type="text/javascript">
			$(function onLoad() {
				document.getElementById("vehicleblock").style.display = "none";
				getAllVehicles();
			});
			function getAllVehicles(){
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all",  
						success:	function(data) {
										var response = JSON.parse(data);
										var content = '<option selected disabled>Liste des véhicules</option>';
										var contenttable = '';
										for (var i = 0; i<response.length; i++) {
											content = content + '<option value="' + response[i].id_vehicle + '">' + response[i].nr_plate + '</option>';
										}
										document.getElementById("listvehicles").innerHTML = content;
									}
					});
				});
			};
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
			function displayVehicle(id) {
				   $.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/" + id,  
					success:	function(data) {
									var response = JSON.parse(data);
									var vehicledetail = '<div class=" col-md-12 col-lg-12 "><table class="table table-user-information">';
									
									vehicledetail += '<tr><td>ID</td><td>' + response[0].id_vehicle + '</td></tr>';
									vehicledetail += '<tr><td>Immatriculation</td><td>' + response[0].nr_plate + '</td></tr>';
									vehicledetail += '<tr><td>Numéro de série</td><td>' + response[0].nr_serial + '</td></tr>';
									vehicledetail += '<tr><td>Date d\'achat</td><td>' + response[0].date_buy + '</td></tr>';
									vehicledetail += '<tr><td>Date de mise en circulation</td><td>' + response[0].date_entryservice + '</td></tr>';
									vehicledetail += '<tr><td>Marque</td><td>' + response[0].brand + '</td></tr>';
									vehicledetail += '<tr><td>Modèle</td><td>' + response[0].model + '</td></tr>';
									vehicledetail += '<tr><td>Energie</td><td>' + response[0].energy + '</td></tr>';
									vehicledetail += '<tr><td>Etat</td><td>' + response[0].state + '</td></tr>';
									vehicledetail += '<tr><td>Catégorie</td><td>' + response[0].category + '</td></tr>';
									vehicledetail += '<tr><td>Type</td><td>' + response[0].kind + '</td></tr>';
									vehicledetail += '<tr><td>Equipement</td><td>' + response[0].equipment + '</td></tr>';
									vehicledetail += '<tr><td>Site</td><td>' + response[0].name + '</td></tr>';
									
									vehicledetail += '</table></div>';
									
									document.getElementById("vehicledetail").innerHTML = vehicledetail;
									document.getElementById("vehicleblock").style.display = "block";
								}
				});
			}
			function saveChangesVehicle() {
				alert('Not available');
			}
			function deleteVehicle() {
					var id = document.getElementById("listvehicles").value;
					$.ajax({
					method: 	"DELETE",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/" + id,
					success:	function(data) {
										$(document).ready(function() {
											document.getElementById("vehicleblock").style.display = "none";
											getAllVehicles();
											$.toast({heading: "Success",text: "Vehicle successfully removed.", icon: "success"});
										});	
									},
					error:		function(xhr, status, error) {
										$(document).ready(function() {
											$.toast({heading: "Error",text: "", icon: "error"});
										});
									}
					});
			}
		</script>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Consultation / Modification des véhicules</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<table class="table-no-border">
										<tr>
											<td><h5>Veuillez sélectionner un véhicule dans la liste</h5></td>
										</tr>
										<tr>
											<td>
												<select id="listvehicles" name="listvehicles" class="form-control" onchange="displayVehicle(this.value);">
													<!-- Retrieve all vehicles with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div id="vehicleblock" class="black-bg btn-menu margin-bottom-20">
					<h2>Informations détaillées</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<table id="vehicledetail" class="table-no-border">
										<!-- Retrieve vehicle detail with an AJAX [GET] query -->
									</table>
									<input type="button" onclick="javascript:deleteVehicle();" value="Supprimer ce véhicule" class="btn btn-danger"/>
									<input type="button" onclick="javascript:saveChangesVehicle();" value="Enregistrer les modifications" class="btn btn-success"/>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   </body>
</html>