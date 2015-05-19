<?php
	session_start();
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/vehicles/vehicles.fr.php');
	else
		include('../../lang/vehicles/vehicles.en.php');
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
		<script src="../../js/jquery.js"></script>
        <script src="../../js/jquery.dataTables.js"></script>	  
	    <script src="../../js/jquery.dataTables.min.js"></script>	
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
				   // Vehicle informations
				   $.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/" + id,  
					success:	function(data) {
									var response = JSON.parse(data);
									var vehicledetail = '<div class="col-md-12 col-lg-12"><table class="table table-user-information">';
									
									vehicledetail += '<tr><td>Plaque d\'immatriculation</td><td><input class="form-control" type="text" id="nr_plate" name="nr_plate" required value="'+ response[0].nr_plate +'" disabled/>' + '</td></tr>';
									vehicledetail += '<tr><td>Numéro de série</td><td><input class="form-control" type="text" id="nr_serial" name="nr_serial" required value="'+ response[0].nr_serial +'" disabled/>' + '</td></tr>';
									vehicledetail += '<tr><td>Date d\'achat</td><td><input data-format="yyyy-mm-dd" type="date" id="date_buy" name="date_buy" required="required" value='+ response[0].date_buy +'></td></tr>';
									vehicledetail += '<tr><td>Date de mise en circulation</td><td><input data-format="yyyy-mm-dd" type="date" id="date_entryservice" name="date_entryservice" required="required" value='+ response[0].date_entryservice +'></td></tr>';
									vehicledetail += '<tr><td>Marque</td><td><select id="brand" name="brand" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Modèle</td><td><select id="model" name="model" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Kilométrage</td><td><input class="form-control" type="text" id="mileage" name="mileage" required value="' + response[0].mileage + '" />' + '</td></tr>';
									vehicledetail += '<tr><td>Energie</td><td><select id="energies" name="energies" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Etat</td><td><select id="states" name="states" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Catégorie</td><td><select id="categories" name="categories" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Prix d\'achat</td><td><input class="form-control" type="text" id="buyingprice" name="buyingprice" required value="' + response[0].buyingprice + '" /><select id="currencies" name="currencies" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Type</td><td><select id="kinds" name="kinds" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Equipement</td><td><select id="equipments" name="equipments" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Site</td><td><select id="sites" name="sites" required="required" class="form-control"></select></td></tr>';
									vehicledetail += '<tr><td>Commentaire</td><td>' + '<textarea class="form-control" rows="5" maxlength="140" id="commentary" name="commentary" >' + response[0].commentary + '</textarea></td></tr>';
									
									vehicledetail += '</table></div>';
									
									document.getElementById("vehicledetail").innerHTML = vehicledetail;
									document.getElementById("vehicleblock").style.display = "block";
									setBrands(response[0].id_brand);
									setModels(response[0].id_model, response[0].id_brand);
									setEnergies(response[0].id_energy);
									setEquipments(response[0].id_equipment);
									setStates(response[0].id_state);
									setCategories(response[0].id_category);
									setKinds(response[0].id_kind);
									setSites(response[0].id_site);
									setCurrencies(response[0].id_currency);
								}
				});
				// Vehicles files
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/" + id + "/files",  
						success:	function(data) {
										var response = JSON.parse(data);
										var dataSet = new Array(response.length);
										for (var i = 0; i<response.length; i++) {
											dataSet[i] = new Array(response[i].date_upload,
															response[i].path,
															'<a href="javascript:removeFile(' + response[i].id_file + ', ' + id + ');"><i class="fa fa-times"></i></a>',
															'<a href="javascript:downloadFile(' + response[i].id_file + ');"><i class="fa fa-download"></i></a>');
										}
										$('#fileslist').dataTable( {
											"data": dataSet,
											"destroy":true,
											"bPaginate": true,
											"bLengthChange": true,
											"bStateSave": true,
											"bFilter": true,
											"bSort": true,
											"bInfo": true,
											"bAutoWidth": true,
											"columns": [
												{ "title": "Date" , "class": "center fctbw" },
												{ "title": "File" , "class": "center fctbw" },
												{ "title": "Delete" , "class": "center fctbw" },
												{ "title": "Download" , "class": "center fctbw" }
											]
										} );
									}
					});
				});
			}
			function downloadFile(id_file) {
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/files/" + id_file + "/path",  
					success:	function(data) {
									var response = JSON.parse(data);
										window.open('../../files/files_vehicles/' + response[0].path);	
								}
				});
			}
			function removeFile(id_file, id) {
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/files/" + id_file + "/path",  
					success:	function(data) {
									var response = JSON.parse(data);
									var path = response[0].path;
									var formData = new FormData();
									formData.append('path', path);
									var xhr = new XMLHttpRequest();
									xhr.open('POST', '../../files/removefile.php?target=files_vehicles', true);
									xhr.onload = function () {
										if (xhr.readyState == 4) {
											if (xhr.status == 200) {
												$.ajax({
													method: 	"DELETE",
													url:		"http://think-parc.com/webservice/v1/files/" + id_file,  
													success:	function(data) {
																	var response = JSON.parse(data);
																	displayVehicle(id);
																	$.toast({heading: "Success",text: "File successfully removed.", icon: "success"});
																}
												});
												
											} else {
												$.toast({heading: "Error",text: "", icon: "error"});
											}	
										} 
									};
									xhr.send(formData);
								}
				});
			}
			function uploadFile() {
				var file = document.getElementById('file-select').files[0];
				var formData = new FormData();

				// Check the file type.
				if (!file.type.match('.pdf') && 
					!file.type.match('.doc') &&
					!file.type.match('.docx') &&
					!file.type.match('.png') &&
					!file.type.match('.jpg') &&
					!file.type.match('.txt') &&
					!file.type.match('.jpeg')) {
						$(document).ready(function() {
							$.toast({heading: "Error",text: "Only documents and pictures are supported (.png, .jpg, .pdf, .doc, .docx)", icon: "error"});
						});
				} else {
					// Add file to data form
					var d = new Date();
					var generatedfilename = d.getTime() + "_" + file.name;
					formData.append('myfiles', file, generatedfilename);
					var xhr = new XMLHttpRequest();
					xhr.open('POST', '../../files/uploadfile.php?target=files_vehicles', true);
					xhr.onload = function () {
						if (xhr.readyState == 4) {
							if (xhr.status == 200) {
								$(document).ready(function() {
									$.ajax({
										method: 	"POST",
										url:		"http://think-parc.com/webservice/v1/files/new/1/" + generatedfilename + "/" + document.getElementById("listvehicles").value,
										success:	function(data) {
															$(document).ready(function() {
																$('#file-form').each(function(){
																	this.reset();
																});
																displayVehicle(document.getElementById("listvehicles").value);
																$.toast({heading: "Success",text: "File successfully uploaded.", icon: "success"});
															});	
														},
										error:		function(xhr, status, error) {
															$(document).ready(function() {
																$.toast({heading: "Error",text: "", icon: "error"});
															});
														}
									});
								});		
							} else {
								$(document).ready(function() {
									$.toast({heading: "Error",text: "", icon: "error"});
								});
							}	
						} 
					};
					xhr.send(formData);
				}
			}
			function setCurrencies(id_currency){
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
									document.getElementById("currencies").value = id_currency;
								}
				});
			};
			function setSites(id_site){
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/sites",  
						success:	function(data) {
										var response = JSON.parse(data);
										var content = '<option selected disabled>Sites</option>';
										for (var i = 0; i<response.length; i++) {
											content = content + '<option value="' + response[i].id_site + '">' + response[i].name + '</option>';
										}
										document.getElementById("sites").innerHTML = content;
										document.getElementById("sites").value = id_site;
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
			function setKinds(id_kind){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/kinds",  
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '<option selected disabled>Genre</option>';
									for (var i = 0; i<response.length; i++) {
										content = content + '<option value="' + response[i].id_kind + '">' + response[i].kind + '</option>';
									}
									document.getElementById("kinds").innerHTML = content;
									document.getElementById("kinds").value = id_kind;
								}
				});
			};
			function setCategories(id_category){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/categories",  
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '<option selected disabled>Categories</option>';
									for (var i = 0; i<response.length; i++) {
										content = content + '<option value="' + response[i].id_category + '">' + response[i].category + '</option>';
									}
									document.getElementById("categories").innerHTML = content;
									document.getElementById("categories").value = id_category;
								}
				});
			};
			function setStates(id_state){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/states",  
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '<option selected disabled>Etats</option>';
									for (var i = 0; i<response.length; i++) {
										content = content + '<option value="' + response[i].id_state + '">' + response[i].state + '</option>';
									}
									document.getElementById("states").innerHTML = content;
									document.getElementById("states").value = id_state;
								}
				});
			};
			function setBrands(id_brand) {
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/brands",  
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '<option selected disabled>Marque du véhicule</option>';
									for (var i = 0; i<response.length; i++) {
										content = content + '<option value="' + response[i].id_brand + '">' + response[i].brand + '</option>';
									}
									document.getElementById("brand").innerHTML = content;
									document.getElementById('brand').value = id_brand;
								}
				});
			}
			function setModels(id_model, id_brand) {
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/models/" + id_brand,  
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '';
									for (var i = 0; i<response.length; i++) {
										content = content + '<option value="' + response[i].id_model + '">' + response[i].model + '</option>';
									}
									document.getElementById("model").innerHTML = content;
									document.getElementById("model").value = id_model;
								}
				});
			}
			function setEnergies(id_energy){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/energies",  
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '<option selected disabled>Energies</option>';
									for (var i = 0; i<response.length; i++) {
										content = content + '<option value="' + response[i].id_energy + '">' + response[i].energy + '</option>';
									}
									document.getElementById("energies").innerHTML = content;
									document.getElementById("energies").value = id_energy;
								}
				});
			}
			function setEquipments(id_equipment){
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/vehicles/equipments",  
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '<option selected disabled>Equipements</option>';
									for (var i = 0; i<response.length; i++) {
										content = content + '<option value="' + response[i].id_equipment + '">' + response[i].equipment + '</option>';
									}
									document.getElementById("equipments").innerHTML = content;
									document.getElementById("equipments").value = id_equipment;
								}
				});
			};
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
			function saveChangesVehicle() {
				var nr_plate = document.getElementById("nr_plate").value;
				var nr_serial = document.getElementById("nr_serial").value;
				var mileage = document.getElementById("mileage").value;
				var buyingprice = document.getElementById("buyingprice").value;
				var date_buy = document.getElementById("date_buy").value;
				var date_entryservice = document.getElementById("date_entryservice").value;
				var energy = document.getElementById("energies").value;
				var model = document.getElementById("model").value;
				var kind = document.getElementById("kinds").value;
				var category = document.getElementById("categories").value;
				var equipment = document.getElementById("equipments").value;
				var state = document.getElementById("states").value;
				var currency = document.getElementById("currencies").value;
				var site = document.getElementById("sites").value;
				var commentary = document.getElementById("commentary").value;
				
				$.ajax({
				method: 	"PUT",
				url:		"http://think-parc.com/webservice/v1/companies/sites/" + site + "/vehicles/" + nr_plate + "/" + nr_serial + 
										"/" + mileage + "/" + buyingprice + "/" + date_buy + "/" + date_entryservice + "/" + energy + 
										"/" + model + "/" + kind + "/" + category + "/" + equipment + "/" + state + "/" + currency + 
										"/" + commentary,
				success:	function(data) {
									$(document).ready(function() {
										$.toast({heading: "Success",text: "Vehicle successfully updated.", icon: "success"});
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
					<h2><?php echo $lang['CONSULT_EDIT_VEHICLE_TITLE']; ?></h2>
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
								</form>
								<input type="button" onclick="javascript:deleteVehicle();" value="Supprimer ce véhicule" class="btn btn-danger"/>
								<input type="button" onclick="javascript:saveChangesVehicle();" value="Enregistrer les modifications" class="btn btn-success"/>
							</div>
						</div>
					</div>
					<h2>Liste des fichiers</h2>
					<form id="file-form" action="javascript:uploadFile();" method="POST">
							<table>
								<tr>
									<td id="files" colspan="2">
										<table class="display" id="fileslist">
											<!-- Here, DataTable of files of selected vehicle -->
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<h5><input class="form-group" type="file" id="file-select" name="myfiles"/></h5>
									</td>
									<td align="right">
										<button type="submit" id="upload-button" class="btn btn-success">Ajouter ce fichier</button>
									</td>
								</tr>
							</table>
					</form>
				</div>
			</div>
		</div>
		<?php include('../footer/footer.php'); ?>
   </body>
</html>