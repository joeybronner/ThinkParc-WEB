<?php
	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/documents/documents.fr.php');
	else
		include('../../lang/documents/documents.en.php');
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Think-Parc | Maintenance</title>
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
		$(function onLoad(){
			getAllVehicles();
			getCurrencies();
			getTypeMaintenance();
		});
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
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/freevehicles", 
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
		var totalitems = 0;
		var buyingprice = "";
		var symbol = "";
		var designation = "";
		function addParts() {
			var radios = document.getElementsByName('stockselected');
			for (var i = 0; i < radios.length; i++) {
				if (radios[i].checked) {
					var reference = document.getElementById("reference").value;
					var quantity = document.getElementById("quantity").value;
					var stocktopickin = radios[i].value;
					addPartToTable(reference, quantity, stocktopickin);
					// Close popup
					cancelAddPart();
				}
			}
		}
		function addPartToTable(reference, quantity, stocktopickin) {
			
			var newpart = 	'<tr id="part-' + totalitems + '">' +
								'<td id="ref-' + totalitems + '">' + reference + '</td>' +
								'<td id="des-' + totalitems + '">' + designation + '</td>' + 
								'<td id="qty-' + totalitems + '">' + quantity + '</td>' +
								'<td id="stk-' + totalitems + '">' + stocktopickin + '</td>' +
								'<td id="prx-' + totalitems + '">' + buyingprice + ' ' + symbol + '</td>' +
								'<td><a href="javascript:removePartFromTable(' + totalitems + ')"><i class="fa fa-times"></i></a></td>' +
							'</tr>';
			totalitems++;
			document.getElementById("partstable").innerHTML = document.getElementById("partstable").innerHTML + newpart;
		}
		function removePartFromTable(id) {
			document.getElementById("part-" + id).remove();
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
		function cancelAddPart() {
			// Reset values
			document.getElementById("stockcontent").innerHTML = "";
			document.getElementById("reference").value = "";
			document.getElementById("quantity").value = "";
			
			// Close popup
			popup('custompopup');
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
		function addNewMaintenance() {
			// Check values
			if (document.getElementById("listvehicles").selectedIndex==0) {
				$.toast({heading: "Error",text: "Please select a vehicle", icon: "error"});
				return false;
			}
			if (document.getElementById("typemaintenance").selectedIndex==0) {
				$.toast({heading: "Error",text: "Please select a type of maintenance", icon: "error"});
				return false;
			}
			// Ok! Now we can add a new maintenance line in the database
			
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
						<h5><i class="fa fa-chevron-left"></i> Retour</h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div id="maintenancefieldsblock" class="black-bg btn-menu margin-bottom-20">
				<h2>Put a vehicle in maintenance</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form id="addmaintenance" action="javascript:addNewMaintenance();">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* Vehicle</h5></td>
											<td colspan="2">
												<select id="listvehicles" name="listvehicles" class="form-control" onchange="showNewMaintenanceFields();">
												<!-- Retrieve all vehicles with an AJAX [GET] query -->
											</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Type of maintenance</h5></td>
											<td colspan="2">
												<select id="typemaintenance" name="typemaintenance" required="required" class="form-control">
													<!-- Retrieve types of maintenance with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Date of starting maintenance</h5></td>
											<td colspan="2">
												<input data-format="yyyy-mm-dd" class="form-control" type="date" name="date_startmaintenance" required="required"/>
											</td>
										</tr>
										<tr>
											<td><h5>Date of ending maintenance</h5></td>
											<td colspan="2">
												<input data-format="yyyy-mm-dd" class="form-control" type="date" name="date_endmaintenance" required="required"/>
											</td>
										</tr>
										<tr>
											<td colspan="3" align="right">
												<h5>
													<a href="javascript:popup('custompopup');">
														<input type="button" value="Add new part" class="btn btn-normal" />
													</a>
												</h5>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<table id="partstable" class="partstable">
													<tr>
														<td class="part_title">Reference</td>
														<td class="part_title">Description</td>
														<td class="part_title">Quantity</td>
														<td class="part_title">StockID</td>
														<td class="part_title">Unit price</td>
														<td class="part_title"><i class="fa fa-eraser"></i></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td><h5>Labour hours</h5></td>
											<td style="padding-top:25px;" colspan="2">
												<input type="number" min="0" class="form-control" id="labour_hours" value="0" step="any"/>
											</td>
										</tr>
										<tr>
											<td><h5>Labour hourly rate</h5></td>
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
											<td><h5>Commentary</h5></td>
											<td colspan="2">
												<textarea id="commentary" class="form-control" rows="3" maxlength="255"></textarea>
											</td>
										</tr>
										<tr>
											<td colspan="3" align="right" style="padding-top:25px;">
												<input type="submit" value="Save" class="btn btn-success"/>
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
										<td><h5>Part reference</h5></td>
										<td>
											<input class="form-control" type="text" id="reference" name="reference" placeholder="Reference" onkeyup="valuesChanges()" />
										</td>
									</tr>
									<tr>
										<td><h5>Quantity</h5></td>
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
											<input type="button" class="btn btn-danger" onclick="javascript:cancelAddPart();" value="Cancel"/>
											<input type="submit" class="btn btn-success" value="Add"/>
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