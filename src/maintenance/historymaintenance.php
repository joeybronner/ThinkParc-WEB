<?php
/* ------------------------------------------------------------------------ *
 *																			*
 * @description:	Description.											*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @lastupdate: 	05/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 * ------------------------------------------------------------------------ */
	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/maintenance/maintenance.fr.php');
	else
		include('../../lang/maintenance/maintenance.en.php');
?>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $maintenance['PAGE_TITLE'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<script src="../../js/popup.js"></script>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery.dataTables.js"></script>	  
	<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	
	<script>
		var totalitems = 0;
		var id_maintenance = "";
		buyingprice = "";
		symbol = "";
		designation = "";
		var partsToDelete = {
			partToDelete: []
		};
		var partsToAdd = {
			partToAdd: []
		};
		$(function onLoad(){
			getAllVehicles();
		});
		function showMaintenanceHistoryForSpecificVehicle(id_vehicle) {
			// Clear parts table
			for (var i=1 ; i<=totalitems ; i++) {
				try {
					//document.getElementById("maintenance-" + i).remove();
					$("[id^='maintenance-']").remove();
				} catch (e) { /* nothing */ }
			}
			// Clear totalitems variable
			totalitems = 0;
			// Get Vehicle infos & maintenance history
			getVehicleHistory(id_vehicle);
			// Load total days in maintenance
			getDaysInMaintenance(id_vehicle);
			// Load total parts used
			getPartsUsed(id_vehicle);
			// Display block
			document.getElementById('maintenancedetails').style.display = 'block';
		}
		function getDaysInMaintenance(id_vehicle) {
			getCompany(function(company){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehicle/" + id_vehicle + "/daysmaintenance", 
					success:	function(data) {
									var response = JSON.parse(data);
									var maintenancedays;
									if (response[0].maintenancedays == null) {
										maintenancedays = 0;
									} else {
										maintenancedays = response[0].maintenancedays;
									}
									$.ajax({
										method: 	"GET",
										url:		"http://think-parc.com/webservice/v1/companies/vehicles/" + id_vehicle, 
										success:	function(data) {
														var responsevehicle = JSON.parse(data);
														var date_buy = new Date(responsevehicle[0].date_buy);
														var date_now = new Date(new Date().yyyymmdd());
														document.getElementById("daysinmaintenance").innerHTML = maintenancedays + "/" + ((date_now - date_buy)/ 86400000);
													},
										async:		false
									});
								},
					async:		false
				});
			});
		}
		function getPartsUsed(id_vehicle) {
			getCompany(function(company){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehicle/" + id_vehicle + "/partsused", 
					success:	function(data) {
									var response = JSON.parse(data);
									document.getElementById("partsused").innerHTML = response[0].quantity;
								}
				});
			});
		}
		Date.prototype.yyyymmdd = function() {         				
			var yyyy = this.getFullYear().toString();                                    
			var mm = (this.getMonth()+1).toString();         
			var dd  = this.getDate().toString();             
			return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
	   };  
		function getCurrencies(){
			$.ajax({
				method: 	"GET",
				url:		"http://think-parc.com/webservice/v1/companies/stocks/currencies",  
				success:	function(data) {
								var response = JSON.parse(data);
								var content = '';
								for (var i = 0; i<response.length; i++) {
									content = content + '<option value="' + response[i].id_currency + '">' + response[i].symbol + '</option>';
								}
								document.getElementById("currencies").innerHTML = content;
							}
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
		function getVehicleHistory(id_vehicle) {
			document.getElementById('partsdetails').style.display = 'none';
			getCompany(function(company){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehicle/" + id_vehicle + "/allmaintenances", 
					success:	function(data) {
									var response = JSON.parse(data);
									for (var i = 0; i<response.length; i++) {
										addMaintenanceToTable(response[i].id_maintenance,
																response[i].date_startmaintenance, 
																response[i].date_endmaintenance, 
																response[i].typemaintenance, 
																response[i].labour_hours, 
																response[i].labour_hourlyrate,
																response[i].symbol);
									}
								}
				});
			});
		}
		function addMaintenanceToTable(id_maintenance, start, end, typemaintenance, hours, rate, symbol) {
			totalitems++;
			var id_vehicle = document.getElementById('listvehicles').value;
			var newmaintenance = '<tr id="maintenance-' + id_maintenance + '">' +
									'<td>' + start + '</td>' +
									'<td>' + end + '</td>' + 
									'<td>' + typemaintenance + '</td>' +
									'<td>' + hours + '</td>' +
									'<td>' + rate + ' ' + symbol + '</td>' +
									'<td id="' + totalitems + '"><a href="javascript:removeMaintenanceFromTable(' + id_maintenance + ', ' + id_vehicle + ')"><i class="fa fa-times"></i></a></td>' +
									'<td><a href="javascript:showPartsForMaintenance(' + id_maintenance + ')"><i class="fa fa-search"></i></a></td>' +
								'</tr>';
			document.getElementById("maintenancestable").innerHTML = document.getElementById("maintenancestable").innerHTML + newmaintenance;
		}
		function showPartsForMaintenance(id_maintenance) {
			getCompany(function(company){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/parts/" + id_maintenance,
					success:	function(data) {
									var response = JSON.parse(data);
									var dataSet = new Array(response.length);
									for (var i = 0; i<response.length; i++) {
										dataSet[i] = new Array(	response[i].reference, 
																response[i].designation,
																response[i].quantity, 
																response[i].buyingprice + response[i].symbol);
									}
									document.getElementById('partsdetails').style.display = 'block';
									$('#parts').html( '<table class="display" cellspacing="0" width="100%" id="example"></table>' );
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
											{ "title": "Reference" , "class": "center fctbw" },
											{ "title": "Description" , "class": "center fctbw" },
											{ "title": "Qt" , "class": "center fctbw" },
											{ "title": "Unit price" , "class": "center fctbw" }
										]
									} );
								}
				});				
			});
		}
		function removeMaintenanceFromTable(id_maintenance, id_vehicle) {
			document.getElementById("maintenance-" + id_maintenance).remove();
			deleteMaintenance(id_maintenance);
			document.getElementById('partsdetails').style.display = 'none';
		}
		function deleteMaintenance(id_maintenance) {
			getCompany(function(company){
				$.ajax({
					url: 	'http://www.think-parc.com/webservice/v1/companies/' + company + '/maintenance/' + id_maintenance,
					type: 	'DELETE',
					async:	false
				});
			});
		}
		Object.size = function(obj) {
			var size = 0, key;
			for (key in obj) {
				if (obj.hasOwnProperty(key)) size++;
			}
			return size;
		}
		Element.prototype.remove = function() {
			this.parentElement.removeChild(this);
		}
		NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
			for(var i = 0, len = this.length; i < len; i++) {
				if(this[i] && this[i].parentElement) {
					this[i].parentElement.removeChild(this[i]);
				}
			}
		}
	</script>
</head>
<body>

	<?php
		include('../header/navbar.php');
	?>

	<img src="../../images/background/maintenance.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=maintenance">
						<h5><i class="fa fa-chevron-left"></i><?php echo $maintenance['BACK'];?></h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu"> <!-- margin-bottom-20-->
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td>
												<h2>History for </h2>
											</td>
											<td>
												<select id="listvehicles" name="listvehicles" class="form-control" onchange="javascript:showMaintenanceHistoryForSpecificVehicle(this.value);">
													<!-- Retrieve all vehicles with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="maintenancedetails" class="black-bg btn-menu" style="display:none;">
				<h2>Maintenance overview for this vehicle</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>Total days maintenance</h5></td>
											<td id="daysinmaintenance" colspan="2">
												<!-- Ajax request to count the number of days in maintenance -->
											</td>
										</tr>
										<tr>
											<td><h5>Total of parts used</h5></td>
											<td id="partsused" colspan="2">
												
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<center><h2>List of maintenance(s)</h2></center>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<table id="maintenancestable" class="partstable">
													<tr>
														<td class="part_title">Début</td>
														<td class="part_title">Fin</td>
														<td class="part_title">Type de maintenance</td>
														<td class="part_title">Heures M.O</td>
														<td class="part_title">Forfait horaire M.O</td>
														<td class="part_title"><i class="fa fa-eraser"></i></td>
														<td class="part_title"><i class="fa fa-search"></i></td>
													</tr>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="partsdetails" class="black-bg btn-menu margin-bottom-20" style="display:none;">
				<h2>Parts detail</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<div class="col-md-12 col-lg-12">
									<div id="parts">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		include('../footer/footer.php');
	?>
</body>
</html>