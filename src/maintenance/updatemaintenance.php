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
	<script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery.backstretch.min.js"></script>
	<script src="../../js/templatemo_script.js"></script>
	<script src="../../js/bootstrap.js"></script>
	<script src="../../js/jquery.toast.js"></script>
	<script src="../../js/popup.js"></script>
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
			getCurrencies();
			getTypeMaintenance();
		});
		function showMaintenanceDetails(id_vehicle) {
			// Clear removed parts table
			partsToDelete = { partToDelete: [] };
			// Clear removed parts table
			partsToAdd = { partToAdd: [] };
			// Clear parts table
			for (var i=1 ; i<=totalitems ; i++) {
				try {
					document.getElementById("part-" + i).remove();
				} catch (e) { /* nothing */ }
			}
			// Clear totalitems variable
			totalitems = 0;
			// Load values
			getVehicleMaintenanceDetail(id_vehicle);
			// Display maintenance detail fields
			document.getElementById('maintenancedetails').style.display = 'block';
		}
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
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehiclesundermaintenance", 
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
		function getTypeMaintenance() {
			$.ajax({
				method: 	"GET",
				url:		"http://think-parc.com/webservice/v1/companies/maintenance/typemaintenance",  
				success:	function(data) {
								var response = JSON.parse(data);
								var content = '<option selected disabled>Type</option>';
								for (var i = 0; i<response.length; i++) {
									content = content + '<option value="' + response[i].id_typemaintenance + '">' + response[i].typemaintenance + '</option>';
								}
								document.getElementById("typemaintenance").innerHTML = content;
							}
			});
		};
		function getVehicleMaintenanceDetail(id_vehicle) {
			getCompany(function(company){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehicle/" + id_vehicle, 
					success:	function(data) {
									var response = JSON.parse(data);
									document.getElementById('typemaintenance').value = response[0].id_typemaintenance;
									document.getElementById('date_startmaintenance').value = response[0].date_startmaintenance;
									document.getElementById('date_endmaintenance').value = response[0].date_endmaintenance;
									document.getElementById('labour_hours').value = response[0].labour_hours;
									document.getElementById('labour_hourlyrate').value = response[0].labour_hourlyrate;
									document.getElementById('currencies').value = response[0].id_currency;
									document.getElementById('commentary').value = response[0].commentary;
									id_maintenance = response[0].id_maintenance;
									// Get used parts
									$.ajax({
										method: 	"GET",
										url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/parts/" + response[0].id_maintenance, 
										success:	function(data) {
														var response = JSON.parse(data);
														for (var i = 0; i<response.length; i++) {
															addPartToTable(response[i].reference, 
																			response[i].quantity, 
																			response[i].id_stock, 
																			response[i].designation, 
																			response[i].buyingprice,
																			response[i].symbol, 
																			false);
														}
													}
									});
								}
				});
			});
		}
		function addPartToTable(reference, quantity, stocktopickin, designation, buyingprice, symbol, newpart) {
			totalitems++;
			if (newpart) {
				partsToAdd.partToAdd.push({ 
					"id_maintenance": id_maintenance,
					"stockid" 		: stocktopickin,
					"quantity"  	: quantity
				});
			}
			var newpart = 	'<tr id="part-' + totalitems + '">' +
								'<td id="ref-' + totalitems + '">' + reference + '</td>' +
								'<td id="des-' + totalitems + '">' + designation + '</td>' + 
								'<td id="qty-' + totalitems + '">' + quantity + '</td>' +
								'<td id="stk-' + totalitems + '">' + stocktopickin + '</td>' +
								'<td id="prx-' + totalitems + '">' + buyingprice + ' ' + symbol + '</td>' +
								'<td><a href="javascript:removePartFromTable(' + totalitems + ')"><i class="fa fa-times"></i></a></td>' +
							'</tr>';
			document.getElementById("partstable").innerHTML = document.getElementById("partstable").innerHTML + newpart;
		}
		function removePartFromTable(id) {
			partsToDelete.partToDelete.push({ 
				"id_maintenance": id_maintenance,
				"stockid" 		: document.getElementById('stk-' + id).innerHTML,
				"quantity"  	: document.getElementById('qty-' + id).innerHTML
			});
			document.getElementById("part-" + id).remove();
		}
		function updateMaintenance() {
			// Add new parts
			for (var i = 0 ; i < Object.size(partsToAdd.partToAdd) ; i++) {
				var add_id_maintenance = partsToAdd.partToAdd[i].id_maintenance;
				var add_stockid = partsToAdd.partToAdd[i].stockid;
				var add_quantity = partsToAdd.partToAdd[i].quantity;
				$.ajax({
					url: 	'http://www.think-parc.com/webservice/v1/companies/' + 0 + 
																	'/maintenance/' + add_id_maintenance + 
																	'/stock/' + add_stockid + 
																	'/quantity/' + add_quantity,
					type: 	'POST',
					async:	false
				});	
			}
			// Delete removed parts in database
			for (var i = 0 ; i < Object.size(partsToDelete.partToDelete) ; i++) {
				var delete_id_maintenance = partsToDelete.partToDelete[i].id_maintenance;
				var delete_stockid = partsToDelete.partToDelete[i].stockid;
				var delete_quantity = partsToDelete.partToDelete[i].quantity;
				$.ajax({
					url: 	'http://www.think-parc.com/webservice/v1/companies/' + 0 + 
																	'/maintenance/' + delete_id_maintenance +
																	'/stock/' + delete_stockid + 
																	'/quantity/' + delete_quantity,
					type: 	'DELETE',
					async:	false
				});
			}
			// Update global values
			var date_endmaintenance = document.getElementById("date_endmaintenance").value;
			var labour_hours = document.getElementById("labour_hours").value;
			var labour_hourlyrate = document.getElementById("labour_hourlyrate").value;
			var id_currency = document.getElementById("currencies").value;
			var commentary = document.getElementById("commentary").value;
			
			// Tranform potential NULL values (commentary & date of end of maintenance)
			date_endmaintenance = ((date_endmaintenance == "") ? "NULL" : date_endmaintenance);
			commentary = ((commentary == "") ? "NULL" : commentary);
			$.ajax({
				url: 	'http://www.think-parc.com/webservice/v1/companies/' + 0 + 
																'/maintenance/' + id_maintenance + 
																'/end/' + date_endmaintenance +
																'/hours/' + labour_hours +
																'/rate/' + labour_hourlyrate + 
																'/curr/' + id_currency + 
																'/commentary/' + commentary,
				type: 	'PUT',
				async:	false,
				success:	function(data) {
								$.toast({heading: "Success",text: "Vehicle maintenance successfuly updated.", icon: "success"});
							}
			});
		}
		Object.size = function(obj) {
			var size = 0, key;
			for (key in obj) {
				if (obj.hasOwnProperty(key)) size++;
			}
			return size;
		}
		function cancelAddPart() {
			// Reset values
			document.getElementById("stockcontent").innerHTML = "";
			document.getElementById("reference").value = "";
			document.getElementById("quantity").value = "";
			
			// Close popup
			popup('custompopup');
		}
		function showPartsStock() {
			var reference = document.getElementById("reference").value;
			var quantity = document.getElementById("quantity").value;
			getCompany(function(company){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/stock/" + reference + "/quantity/" + quantity, 
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '<center><table>' + 
													'<tbody style="display:block; height:250px; overflow-y:auto;">' + 
														'<tr>' +
															'<td></td>' + 
															'<td class="littletable"><h6>Site</h6></td>' +
															'<td class="littletable"><h6>Qty</h6></td>' +
															'<td class="littletable"><h6>Driveway</h6></td>' +
															'<td class="littletable"><h6>Bay</h6></td>' + 
															'<td class="littletable"><h6>Position</h6></td>' + 
															'<td class="littletable"><h6>Rack</h6></td>' +
															'<td class="littletable"><h6>Locker</h6></td>' +
														'</tr>';
									for (var i = 0; i<response.length; i++) {
										content = content + '<tr>' + 
																'<td class="littletable"><input type="radio" name="stockselected" value="' + response[i].id_stock + '" />' + '</td>' + 
																'<td class="littletable"><h6>' + response[i].name + '</h6></td>' + 
																'<td class="littletable"><h6>' + response[i].quanty + '</h6></td>' + 
																'<td class="littletable"><h6>' + response[i].driveway + '</h6></td>' + 
																'<td class="littletable"><h6>' + response[i].bay + '</h6></td>' + 
																'<td class="littletable"><h6>' + response[i].position + '</h6></td>' + 
																'<td class="littletable"><h6>' + response[i].rack + '</h6></td>' + 
																'<td class="littletable"><h6>' + response[i].locker + '</h6></td>' + 
															'</tr>';
										buyingprice = response[i].buyingprice;
										designation = response[i].designation;
										symbol = response[i].symbol;
									}
									document.getElementById("stockcontent").innerHTML = content;
								}
				});
			});
		}
		function valuesChanges() {
			var reference = document.getElementById("reference").value;
			var quantity = document.getElementById("quantity").value;
			// Checkif reference isn't null and quantity is a numeric number
			if (reference != "" && isNaN(quantity)==false && quantity > 0) {
				showPartsStock();
			} else {
				document.getElementById("stockcontent").innerHTML = "<h6>Not available is your stock.</h6>";
			}
		}
		function addParts() {
			var radios = document.getElementsByName('stockselected');
			for (var i = 0; i < radios.length; i++) {
				if (radios[i].checked) {
					var reference = document.getElementById("reference").value;
					var quantity = document.getElementById("quantity").value;
					var stocktopickin = radios[i].value;
					addPartToTable(reference, quantity, stocktopickin, designation, buyingprice, symbol, true);
					// Close popup
					cancelAddPart();
				}
			}
		}
		function deleteMaintenance() {
			getCompany(function(company){
				$.ajax({
					url: 	'http://www.think-parc.com/webservice/v1/companies/' + company + '/maintenance/' + id_maintenance,
					type: 	'DELETE',
					async:	false,
					success:	function(data) {
									$.toast({heading: "Success",text: "Vehicle maintenance successfuly removed.", icon: "success"});
									document.getElementById('maintenancedetails').style.display = 'none';
									getAllVehicles();
								}
				});
			});
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
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=maintenance">
						<h5><i class="fa fa-chevron-left"></i><?php echo $maintenance['BACK'];?></h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $maintenance['UPDATE_VEHICLE_TITLE'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5><?php echo $maintenance['VEHICLE'];?></h5></td>
											<td>
												<select id="listvehicles" name="listvehicles" class="form-control" onchange="javascript:showMaintenanceDetails(this.value);">
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
			<div id="maintenancedetails" class="black-bg btn-menu margin-bottom-20" style="display:none;">
				<h2><?php echo $maintenance['MAINTENANCE_DETAILS'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5><?php echo $maintenance['TYPE_MAINTENANCE'];?></h5></td>
											<td colspan="2">
												<select id="typemaintenance" name="typemaintenance" class="form-control" disabled>
													<!-- Retrieve types of maintenance with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $maintenance['START_MAINTENANCE'];?></h5></td>
											<td colspan="2">
												<input data-format="yyyy-mm-dd" class="form-control" type="date" id="date_startmaintenance" disabled />
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $maintenance['END_MAINTENANCE'];?></h5></td>
											<td colspan="2">
												<input data-format="yyyy-mm-dd" class="form-control" type="date" id="date_endmaintenance" />
											</td>
										</tr>
										<tr>
											<td colspan="3" align="right">
												<h5>
													<a href="javascript:popup('custompopup');">
														<input type="button" value="<?php echo $maintenance['ADD_PART'];?>" class="btn btn-normal" />
													</a>
												</h5>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<table id="partstable" class="partstable">
													<tr>
														<td class="part_title"><?php echo $maintenance['TABLE_REFERENCE'];?></td>
														<td class="part_title"><?php echo $maintenance['TABLE_DESCRIPTION'];?></td>
														<td class="part_title"><?php echo $maintenance['TABLE_QUANTITY'];?></td>
														<td class="part_title"><?php echo $maintenance['TABLE_STOCKID'];?></td>
														<td class="part_title"><?php echo $maintenance['TABLE_UNITPRICE'];?></td>
														<td class="part_title"><i class="fa fa-eraser"></i></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $maintenance['LABOUR_HOURS'];?></h5></td>
											<td style="padding-top:25px;" colspan="2">
												<input type="number" min="0" class="form-control" id="labour_hours" value="0" step="any"/>
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $maintenance['LABOUR_HOURLYRATE'];?></h5></td>
											<td>
												<input type="number" min="0" class="form-control" id="labour_hourlyrate" value="0" step="any"/>
											</td>
											<td>
												<select id="currencies" name="currencies" class="form-control">
													<!-- Retrieve equipments with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $maintenance['COMMENTARY'];?></h5></td>
											<td colspan="2">
												<textarea id="commentary" class="form-control" rows="3" maxlength="255"></textarea>
											</td>
										</tr>
										<tr>
											<td colspan="3" align="right" style="padding-top:25px;text-align:center;">
												<input type="button" value="<?php echo $maintenance['DELETE_MAINTENANCE'];?>" class="btn btn-danger" onclick="javascript:deleteMaintenance()"/>
												<input type="button" value="<?php echo $maintenance['UPDATE_MAINTENANCE'];?>" class="btn btn-success" onclick="javascript:updateMaintenance()"/>
											</td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- PopUp section -->
	<div id="blanket" style="display:none"></div>
	<div id="custompopup" style="display:none">
			<div class="panel-body">
				<div class="row"> 
						<form id="addmaintenance" action="javascript:addParts();">
							<table style="width:100%;">
								<tbody>
									<tr>
										<td><h5><?php echo $maintenance['PART_REFERENCE'];?></h5></td>
										<td>
											<input class="form-control" type="text" id="reference" name="reference" placeholder="Reference" onkeyup="valuesChanges()" />
										</td>
									</tr>
									<tr>
										<td><h5><?php echo $maintenance['QUANTITY'];?></h5></td>
										<td>
											<input class="form-control" type="number" min="0" value="1" id="quantity" name="quantity" onkeyup="valuesChanges()" />
										</td>
									</tr>
									<tr>
										<td id="stockstatus" colspan="2">
											<center>
												<table> 
													<tbody id="stockcontent" style="display:block; height:250px; overflow-y:auto;">
														<!-- Stock content -->
													</tbody>
												</table>
											</center>
										</td>
									</tr>
									<tr>
										<td colspan="2" align="right">
											<input type="button" class="btn btn-danger" onclick="javascript:cancelAddPart();" value="<?php echo $maintenance['BT_CANCEL'];?>"/>
											<input type="submit" class="btn btn-success" value="<?php echo $maintenance['BT_ADD'];?>"/>
										</td>
									</tr>
								</tbody>
							</table>
						</form>
				</div>
			</div>
	</div>
	<!-- End PopUp section -->
	<?php
		include('../footer/footer.php');
	?>
</body>
</html>