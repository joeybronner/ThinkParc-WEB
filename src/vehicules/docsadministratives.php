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
				document.getElementById("administrativeblock").style.display = "none";
				getAllVehicles();
				getInsurances();
			});
			function getInsurances() {
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/administratives/insurances/all",  
						success:	function(data) {
										var response = JSON.parse(data);
										var content = '<option selected disabled>Veuillez sélectionner un assureur dans la liste</option>';
										var contenttable = '';
										for (var i = 0; i<response.length; i++) {
											content = content + '<option value="' + response[i].id_insurance + '">' + response[i].name + 
																		' (' + response[i].address_ligne1 + ', ' + response[i].zipcode + ' ' + response[i].country +
																')</option>';
										}
										document.getElementById("insurances").innerHTML = content;
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
				document.getElementById("administrativeblock").style.display = "block";
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/administratives/" + id,
						success:	function(data) {
										var response = JSON.parse(data);
										for (var i = 0; i<response.length; i++) {
											document.getElementById("nr_contract").value = response[i].nr_contract;
											document.getElementById("date_lastcontrol").value = response[i].date_lastcontrol;
											document.getElementById("date_nextcontrol").value = response[i].date_nextcontrol;
											document.getElementById("date_startinsurance").value = response[i].date_startinsurance;
											document.getElementById("date_endinsurance").value = response[i].date_endinsurance;
											document.getElementById("insurances").value = response[i].id_insurance;
										}
										
										if (response.length < 1) {
											document.getElementById("nr_contract").value = '';
											document.getElementById("date_lastcontrol").value = '';
											document.getElementById("date_nextcontrol").value = '';
											document.getElementById("date_startinsurance").value = '';
											document.getElementById("date_endinsurance").value = '';
											document.getElementById("insurances").value = 0;
											document.getElementById("addAdministrative").style.display = "block";
											document.getElementById("updateAdministrative").style.display = "none";
										} else {
											document.getElementById("addAdministrative").style.display = "none";
											document.getElementById("updateAdministrative").style.display = "block";

										}
									}
					});
				});
			}
			function hideVehicles() {
				document.getElementById("administrativeblock").style.display = "none";
			}
			function newinsurancefields() {
				var list = true;
				var newinsurance = false;
				if (document.getElementById("insurances").disabled) {
					restartNewInsuranceValues();
					getInsurances();
					list = false;
					newinsurance = true;
				} else {
					document.getElementById("insur_choice").className = "fa fa-sort-down";
					document.getElementById("insurances").value = 0;
					list = true;
					newinsurance = false;
				}
				document.getElementById("insurances").disabled = list;
				document.getElementById('ins_name').disabled = newinsurance;
				document.getElementById('ins_add1').disabled = newinsurance;
				document.getElementById('ins_add2').disabled = newinsurance;
				document.getElementById('ins_add3').disabled = newinsurance;
				document.getElementById('ins_zipcode').disabled = newinsurance;
				document.getElementById('ins_phone').disabled = newinsurance;
				document.getElementById('ins_email').disabled = newinsurance;
				document.getElementById('ins_city').disabled = newinsurance;
				document.getElementById('ins_country').disabled = newinsurance;
			}
			function restartNewInsuranceValues() {
				document.getElementById("insur_choice").className = "fa fa-sort-up";
				document.getElementById('ins_name').value = "";
				document.getElementById('ins_add1').value = "";
				document.getElementById('ins_add2').value = "";
				document.getElementById('ins_add3').value = "";
				document.getElementById('ins_zipcode').value = "";
				document.getElementById('ins_phone').value = "";
				document.getElementById('ins_email').value = "";
				document.getElementById('ins_city').value = "";
				document.getElementById('ins_country').value = "";
			}
			function saveChangesAdministrative() {
				// First add new insurance if necessary
				var id_vehicle = document.getElementById("listvehicles").value;
				if (document.getElementById('ins_name').value == '') {
					// Update administrative doc
					updateDocsAdministrative(document.getElementById("insurances").value, id_vehicle);
				} else {
					// Insert insurance
					insertInsurance(function(insurance){
						// Update administrative doc
						updateDocsAdministrative(insurance, id_vehicle);
						newinsurancefields();
					});
				}
				hideVehicles();
				getAllVehicles();
			}
			function saveAdministrative() {
				// First add new insurance if necessary
				var id_vehicle = document.getElementById("listvehicles").value;
				if (document.getElementById('ins_name').value == '') {
					// Insert administrative doc
					insertDocsAdministrative(document.getElementById("insurances").value,id_vehicle);
				} else {
					// Insert insurance
					insertInsurance(function(insurance){
						// Insert administrative doc
						insertDocsAdministrative(insurance, id_vehicle);
					});
				}
				newinsurancefields();
				hideVehicles();
				getAllVehicles();
			}
			function updateDocsAdministrative(id_insurance, id_vehicle) {
				// Add into docsadministrative
				getCompany(function(company){
					var nr_contract = document.getElementById("nr_contract").value;
					var date_lastcontrol = document.getElementById("date_lastcontrol").value;
					var date_nextcontrol = document.getElementById("date_nextcontrol").value;
					var date_startinsurance = document.getElementById("date_startinsurance").value;
					var date_endinsurance = document.getElementById("date_endinsurance").value;
					$.ajax({
						method: 	"PUT",
						url:		"http://think-parc.com/webservice/v1/companies/"+company+"/administratives/docs/"+id_vehicle+"/"+nr_contract+"/"+date_lastcontrol+"/"+date_nextcontrol+"/"+date_startinsurance+"/"+date_endinsurance+"/"+id_insurance,
						success:	function(data) {
											$(document).ready(function() {
												document.getElementById("addAdministrative").style.display = "none";
												document.getElementById("updateAdministrative").style.display = "block";
												$.toast({heading: "Success",text: "Administrative document successfully updated.", icon: "success"});
											});	
										},
						error:		function(xhr, status, error) {
											$(document).ready(function() {
												$.toast({heading: "Error",text: "An error occured", icon: "error"});
											});
										}
					});
				});
			}
			function insertInsurance(handleData) {
				// Add into insurances and retrieve new ID insurance
				var ins_name = document.getElementById("ins_name").value;
				var ins_phone = document.getElementById("ins_phone").value;
				var ins_email = document.getElementById("ins_email").value;
				var ins_add1 = document.getElementById("ins_add1").value;
				var ins_add2 = document.getElementById("ins_add2").value;
				var ins_add3 = document.getElementById("ins_add3").value;
				var ins_zipcode = document.getElementById("ins_zipcode").value;
				var ins_city = document.getElementById("ins_city").value;
				var ins_country = document.getElementById("ins_country").value;
				getCompany(function(company){
					$.ajax({
						method: 	"POST",
						url:		"http://think-parc.com/webservice/v1/companies/"+company+"/administratives/insurances/"+ins_name+"/"+ins_phone+"/"+ins_email+"/"+ins_add1+"/"+ins_add2+"/"+ins_add3+"/"+ins_zipcode+"/"+ins_city+"/"+ins_country,
						success:	function(data) {
										json = JSON.parse(data);
										handleData(json["Success"]);
									}
					});
				});
			}
			function insertDocsAdministrative(id_insurance, id_vehicle) {
				// Add into docsadministrative
				getCompany(function(company){
					var nr_contract = document.getElementById("nr_contract").value;
					var date_lastcontrol = document.getElementById("date_lastcontrol").value;
					var date_nextcontrol = document.getElementById("date_nextcontrol").value;
					var date_startinsurance = document.getElementById("date_startinsurance").value;
					var date_endinsurance = document.getElementById("date_endinsurance").value;
					$.ajax({
						method: 	"POST",
						url:		"http://think-parc.com/webservice/v1/companies/"+company+"/administratives/docs/"+id_vehicle+"/"+nr_contract+"/"+date_lastcontrol+"/"+date_nextcontrol+"/"+date_startinsurance+"/"+date_endinsurance+"/"+id_insurance,
						success:	function(data) {
											$(document).ready(function() {
												document.getElementById("addAdministrative").style.display = "none";
												document.getElementById("updateAdministrative").style.display = "block";
												$.toast({heading: "Success",text: "Administrative document successfully added.", icon: "success"});
											});	
										},
						error:		function(xhr, status, error) {
											$(document).ready(function() {
												$.toast({heading: "Error",text: "An error occured", icon: "error"});
											});
										}
					});
				});
			}
		</script>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
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
				<div id="administrativeblock" class="black-bg btn-menu margin-bottom-20">
					<h2>Documents administratifs concernant ce véhicule</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12"><table class="table table-user-information">
										<table id="vehicledetail" class="table-no-border">
											<tbody>
												<tr>
													<td style="width:50%;">N° du contrat d'assurance</td>
													<td>
														<input class="form-control" type="text" id="nr_contract" name="nr_contract" required>
													</td>
												</tr>
												<tr>
													<td>Dernier contrôle technique</td>
													<td>
														<input data-format="yyyy-mm-dd" type="date" class="form-control" id="date_lastcontrol" name="date_lastcontrol" required>
													</td>
												</tr>
												<tr>
													<td>Prochain contrôle technique</td>
													<td>
														<input data-format="yyyy-mm-dd" type="date" class="form-control" id="date_nextcontrol" name="date_nextcontrol" required>
													</td>
												</tr>
												<tr>
													<td>Début du contrat d'assurance</td>
													<td>
														<input data-format="yyyy-mm-dd" type="date" class="form-control" id="date_startinsurance" name="date_startinsurance" required>
													</td>
												</tr>
												<tr>
													<td>Fin du contrat d'assurance</td>
													<td>
														<input data-format="yyyy-mm-dd" type="date" class="form-control" id="date_endinsurance" name="date_endinsurance" required>
													</td>
												</tr>
												<tr>
													<td>Assureurs</td>
													<td>
														<select id="insurances" name="insurances" required class="form-control"></select>
													</td>
													<td align="right">
														<a href="javascript:newinsurancefields();"><i id="insur_choice" class="fa fa fa-sort-up"></i></a>
													</td>
												</tr>
												<tr>
													<td>Nom de l'assureur</td>
													<td>
														<input class="form-control" type="text" id="ins_name" name="ins_name" disabled>
													</td>
												</tr>
												<tr>
													<td>Téléphone</td>
													<td>
														<input class="form-control" type="text" id="ins_phone" name="ins_phone" disabled>
													</td>
												</tr>
												<tr>
													<td>Email</td>
													<td>
														<input class="form-control" type="text" id="ins_email" name="ins_email" disabled>
													</td>
												</tr>
												<tr>
													<td>Adresse (ligne 1)</td>
													<td>
														<input class="form-control" type="text" id="ins_add1" name="ins_add1" disabled>
													</td>
												</tr>
												<tr>
													<td>Adresse (ligne 2)</td>
													<td>
														<input class="form-control" type="text" id="ins_add2" name="ins_add2" disabled>
													</td>
												</tr>
												<tr>
													<td>Adresse (ligne 3)</td>
													<td>
														<input class="form-control" type="text" id="ins_add3" name="ins_add3" disabled>
													</td>
												</tr>
												<tr>
													<td>Code postal</td>
													<td>
														<input class="form-control" type="text" id="ins_zipcode" name="ins_zipcode" disabled>
													</td>
												</tr>
												<tr>
													<td>Ville</td>
													<td>
														<input class="form-control" type="text" id="ins_city" name="ins_city" disabled>
													</td>
												</tr>
												<tr>
													<td>Pays</td>
													<td>
														<input class="form-control" type="text" id="ins_country" name="ins_country" disabled>
													</td>
												</tr>
												<tr>
													<td>
														<input type="button" onclick="javascript:saveAdministrative();" id ="addAdministrative" value="Enregistrer" class="btn btn-success"/>
														<input type="button" onclick="javascript:saveChangesAdministrative();" id ="updateAdministrative" value="Mettre à jour" class="btn btn-success"/>
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