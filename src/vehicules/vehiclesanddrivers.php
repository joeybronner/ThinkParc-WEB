<?php
   session_start();
?>
<html>
	<head>
		<title>Véhicules et conducteurs</title>
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
		<meta name="description" content="">
		<meta charset="utf-8">
		<link rel="stylesheet" href="../../css/bootstrap.css">
		<link rel="stylesheet" href="../../css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">
		<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
		<link rel="stylesheet" href="../../css/DataTable/jquery.dataTables_themefct.css">
		<link rel="stylesheet" href="../../css/datepicker/datepicker.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/jquery.backstretch.min.js"></script>
		<script src="../../js/templatemo_script.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script src="../../js/jquery.toast.js"></script>
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/jquery.dataTables.js"></script>	  
	    <script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
		<script type="text/javascript">
			$(function onLoad() {
				document.getElementById("vehiclesanddriversdetail").style.display = "none";
				document.getElementById("addentry").style.display = "none";
				getAllVehicles();
				getAllDrivers();
				// Init date fields
				$('#date_start').datepicker();
				$('#date_end').datepicker();
			});
			function getAllDrivers() {
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/administratives/vehicles/drivers",  
						success:	function(data) {
										var response = JSON.parse(data);
										var content = '<option selected disabled>Liste des conducteurs</option>';
										for (var i = 0; i<response.length; i++) {
											content = content + '<option value="' + response[i].id_driver + '">' + response[i].firstname + ' ' + response[i].lastname + '(' + response[i].nr_drivinglicence + ')</option>';
										}
										document.getElementById("listdrivers").innerHTML = content;
									}
					});
				});
			};
			function getAllVehicles(){
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all",  
						success:	function(data) {
										var response = JSON.parse(data);
										var content = '<option selected disabled>Liste des véhicules</option>';
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
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/administratives/vehicles/" + id + "/drivers",
						success:	function(data) {
										var response = JSON.parse(data);
										var dataSet = new Array(response.length);
										for (var i = 0; i<response.length; i++) {
											dataSet[i] = new Array(	response[i].firstname + " " + response[i].lastname, 
																	response[i].nr_drivinglicence, 
																	reformatDate(response[i].date_start), 
																	reformatDate(response[i].date_end),
																	'<a href="javascript:removeEntry(' + response[i].id_driveduration + ');"><i id="icon_remove" class="fa fa-times"></i></a>');
										}
										
										$('#drivers').html( '<table class="display" id="example"></table>' );
							
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
												{ "title": "Conducteur" , "class": "center fctbw" },
												{ "title": "N° de permis de conduire" , "class": "center fctbw"},
												{ "title": "Date de début" , "class": "center fctbw" },
												{ "title": "Date de fin", "class": "center fctbw" },
												{ "title": "", "class": "center fctbw" }
											]
										} );
									}
					});

					document.getElementById("vehiclesanddriversdetail").style.display = "block";					
				
				});
			}
			function showAddDriverFields() {
				document.getElementById("addentry").style.display = "block";
				document.getElementById("btshowfields").style.display = "none";
			}
			function removeEntry(id_driveduration) {
				getCompany(function(company){
					console.log("http://think-parc.com/webservice/v1/companies/" + company + "/administratives/driveduration/" + id_driveduration);
					$.ajax({
						method: 	"DELETE",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/administratives/driveduration/" + id_driveduration,
						success:	function(data) {
										$(document).ready(function() {
											json = JSON.parse(data);
											displayVehicle(document.getElementById("listvehicles").value);
										});	
									}
					});
				});
			}
			function addEntry() {			
				if (document.getElementById("listdrivers").disabled) {
					insertDriver(function(id_driver){
						insertDriveDuration(id_driver);
					});
				} else {
					insertDriveDuration(document.getElementById("listdrivers").value);
				}
				
			}
			function insertDriveDuration(id_driver) {
				// Retrieve values
				var id_vehicle = document.getElementById("listvehicles").value;
				var date_start = document.getElementById("date_start").value.split("/").reverse().join("-");
				var date_end = document.getElementById("date_end").value.split("/").reverse().join("-");
				getCompany(function(company){
					$.ajax({
						method: 	"POST",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/administratives/vehicles/" + id_vehicle + "/driver/existant/" + id_driver + "/" + date_start + "/" + date_end,
						success:	function(data) {
										json = JSON.parse(data);	
										document.getElementById("firstname").value = '';
										document.getElementById("lastname").value = '';
										document.getElementById("nr_drivinglicence").value = '';
										document.getElementById("date_start").value = '';
										document.getElementById("date_end").value = '';
										displayVehicle(document.getElementById("listvehicles").value);
									}
					});
				});
			}
			function insertDriver(handleData) {
				var firstname = document.getElementById("firstname").value;
				var lastname = document.getElementById("lastname").value;
				var nr_drivinglicence = document.getElementById("nr_drivinglicence").value;
				getCompany(function(company){
					$.ajax({
						method: 	"POST",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/administratives/vehicles/drivers/" + firstname + "/" + lastname + "/" + nr_drivinglicence,
						success:	function(data) {
										json = JSON.parse(data);
										handleData(json["Success"]);
									}
					});
				});
			}
			function newDriverFields() {
				var list = false;
				var newdriver = true;
				getAllDrivers();
				if (document.getElementById("listdrivers").disabled) {
					document.getElementById("driver_choice").className = "fa fa-sort-down";
					list = false;
					newdriver = true;
				} else {
					document.getElementById("driver_choice").className = "fa fa-sort-up";
					document.getElementById("listdrivers").value = 0;
					list = true;
					newdriver = false;
				}
				document.getElementById("listdrivers").disabled = list;
				document.getElementById('firstname').disabled = newdriver;
				document.getElementById('lastname').disabled = newdriver;
				document.getElementById('nr_drivinglicence').disabled = newdriver;
			}
			function showAddDriverFields() {
				document.getElementById("btshowfields").style.display = "none";
				document.getElementById("addentry").style.display = "block";
			}
			function reformatDate(dateStr) {
				dArr = dateStr.split("-");
				return dArr[2]+ "/" +dArr[1]+ "/" +dArr[0];
			}
		</script>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/background/vehicles/think_parc_vehicles_1.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
					<a href="../accueil.php?section=vehicles">
							<h5><i class="fa fa-chevron-left"></i> Retour</h5>
					</a>
				</div>
			</div>
			<div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Détails administratifs de vos véhicules</h2>
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
				<div id="vehiclesanddriversdetail" class="black-bg btn-menu margin-bottom-20">
					<h2>Historique</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12">
										<table id="vehicledetail" class="table-no-border">
											<tbody>
												<tr>
													<td>Historique des conducteurs de ce véhicule</td>
												</tr>
												<tr>
													<td id="drivers">
														
													</td>
												</tr>
												<tr id="btshowfields">
													<td>
														<a href="javascript:showAddDriverFields();"><i id="add" class="fa fa-plus-circle"></i>
														Ajouter un conducteur</a>
													</td>
												</tr>
											</tbody>
										</table>
										<table id="addentry" class="table-no-border">
											<tbody>
												<tr>
													<td>Conducteurs</td>
													<td>
														<select id="listdrivers" name="listdrivers" required class="form-control"></select>
													</td>
													<td align="right">
														<a href="javascript:newDriverFields();"><i id="driver_choice" class="fa fa-sort-down"></i></a>
													</td>
												</tr>
												<tr>
													<td>Prénom</td>
													<td>
														<input class="form-control" type="text" id="firstname" name="firstname" disabled>
													</td>
												</tr>
												<tr>
													<td>Nom</td>
													<td>
														<input class="form-control" type="text" id="lastname" name="lastname" disabled>
													</td>
												</tr>
												<tr>
													<td>N° de permis</td>
													<td>
														<input class="form-control" type="text" id="nr_drivinglicence" name="nr_drivinglicence" disabled>
													</td>
												</tr>
												<tr>
													<td>Date de début</td>
													<td>
														<input type="text" class="form-control" id="date_start" name="date_start" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
													</td>
												</tr>
												<tr>
													<td>Date de fin</td>
													<td>
														<input type="text" class="form-control" id="date_end" name="date_end" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
													</td>
												</tr>
												<tr>
													<td>
														<input type="button" onclick="javascript:addEntry();" value="Ajouter" class="btn btn-success"/>
													</td>	
												</tr>
											</tbody>
										</table>
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