<?php
session_start();
?>

<html>
<head>
	<meta charset="utf-8" />
	<title>Ajouter un véhicule</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/templatemo_main.css">
	<link rel="stylesheet" href="../../css/app.css">
	<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
    <link rel="stylesheet" href="../../css/datepicker/datepicker.css">
	<script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery.backstretch.min.js"></script>
	<script src="../../js/templatemo_script.js"></script>
	<script src="../../js/bootstrap.js"></script>
	<script src="../../js/jquery.toast.js"></script>
	<script src="../../js/bootstrap-datepicker.js"></script>
	<script>
	$(function(){
		// Init date fields
		$('#date_buy').datepicker();
		$('#date_entryservice').datepicker();
	});
	$(function getBrands(){
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
						}
		});
	});
	function getModels(idbrand){
	   	$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/vehicles/models/" + idbrand,  
			success:	function(data) {
							var response = JSON.parse(data);
							var content = '';
							for (var i = 0; i<response.length; i++) {
								content = content + '<option value="' + response[i].id_model + '">' + response[i].model + '</option>';
							}
							document.getElementById("model").innerHTML = content;
							document.getElementById("model").disabled = false;
						}
		});
	};
	$(function getKinds(){
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
						}
		});
	});
	$(function getCategories(){
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
						}
		});
	});
	$(function getEnergies(){
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
						}
		});
	});
	$(function getEquipments(){
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
						}
		});
	});
	$(function getSites(){
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
							}
			});
		});
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
	$(function getStates(){
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
						}
		});
	});
	$(function getCurrencies(){
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
	});
	function addVehicule() {
		var nr_plate = document.getElementById("nr_plate").value;
		var nr_serial = document.getElementById("nr_serial").value;
		var mileage = document.getElementById("mileage").value;
		var buyingprice = document.getElementById("buyingprice").value;
		var date_buy = document.getElementById("date_buy").value.split("/").reverse().join("-");
		var date_entryservice = document.getElementById("date_entryservice").value.split("/").reverse().join("-");
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
		method: 	"POST",
		url:		"http://think-parc.com/webservice/v1/companies/sites/" + site + "/vehicles/" + nr_plate + "/" + nr_serial + 
								"/" + mileage + "/" + buyingprice + "/" + date_buy + "/" + date_entryservice + "/" + energy + 
								"/" + model + "/" + kind + "/" + category + "/" + equipment + "/" + state + "/" + currency + 
								"/" + commentary,
       	success:	function(data) {
        					$(document).ready(function() {
								document.getElementById("addvehicle").reset();
        						$.toast({heading: "Success",text: "Vehicle successfully added.", icon: "success"});
        					});	
        				},
        error:		function(xhr, status, error) {
        					$(document).ready(function() {
        						$.toast({heading: "Error",text: "An error occured, a value is required for all fields. Please check your entries and try again.", icon: "error"});
        					});
        				}
        });
	};
	</script>
</head>
<body>

	<?php
		include('../header/navbar.php');
	?>

	<img src="../../images/background/vehicles/think_parc_vehicles_3.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
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
				<h2>Ajouter un véhicule</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form id="addvehicle" method="get" action="javascript:addVehicule();">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* Marque & Modèle</h5></td>
										</tr>
										<tr>
											<td>
												<select id="brand" name="brand" required="required" class="form-control" onchange="getModels(this.value);">
													<!-- Retrieve brands with an AJAX [GET] query -->
												</select>
											</td>
											<td>
												<select id="model" name="model" required="required" class="form-control" disabled>
													<option selected disabled>Modele du véhicule</option>
													<!-- Retrieve models with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Genre & Catégorie</h5></td>
										</tr>
										<tr>
											<td>
												<select id="kinds" name="kinds" required="required" class="form-control">
													<!-- Retrieve kinds with an AJAX [GET] query -->
												</select>
											</td>
											<td>
												<select id="categories" name="categories" required="required" class="form-control">
													<!-- Retrieve categories with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Energie & Equipements spéciaux</h5></td>
										</tr>
										<tr>
											<td>
												<select id="energies" name="energies" required="required" class="form-control">
													<!-- Retrieve energies with an AJAX [GET] query -->
												</select>
											</td>
											<td>
												<select id="equipments" name="equipments" required="required" class="form-control">
													<!-- Retrieve equipments with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>Prix d'achat</h5></td>
										</tr>
										<tr>
											<td>
												<input class="form-control" type="text" id="buyingprice" name="buyingprice" placeholder="Prix d'achat" required/>
											</td>
											<td>
												<select id="currencies" name="currencies" required="required" class="form-control">
													<!-- Retrieve equipments with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>Matricule & Numéro de série</h5></td>
										</tr>
										<tr>
											<td>
												<input class="form-control" type="text" id="nr_plate" name="nr_plate" placeholder="Matricule"/>
											</td>
											<td>
												<input class="form-control" type="text" id="nr_serial" name="nr_serial" placeholder="Numéro de série"/>
											</td>
										</tr>
										<tr>
											<td><h5>* Date d'achat</h5></td>
											<td>
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_buy" name="date_buy" placeholder="JJ/MM/AAAA" required>
											</td>
										</tr>
										<tr>
											<td><h5>* Date de mise en circulation</h5></td>
											<td>
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_entryservice" name="date_entryservice" placeholder="JJ/MM/AAAA" required>
											</td>
										</tr>
										<tr>
											<td><h5>* Kilométrage</h5></td>
											<td>
												<input class="form-control" type="text" id="mileage" name="mileage" required="required" placeholder="100 000"/>
											</td>
										</tr>
										<tr>
											<td><h5>Commentaires</h5></td>
											<td>
												<textarea class="form-control" rows="5" maxlength="140" id="commentary" name="commentary" placeholder="Commentaires "></textarea>
											</td>
										</tr>
										<tr>
											
										</tr>
										<tr>
											<td><h5>* Site</h5></td>
											<td>
												<select id="sites" name="sites" required="required" class="form-control">
													<!-- Retrieve sites with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Etat</h5></td>
											<td>
												<select id="states" name="states" required="required" class="form-control">
													<!-- Retrieve states with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="right">
												<input type="reset" value="Reinitialiser" class="btn btn-warning"/>
												<input type="submit" class="btn btn-success" value="Enregistrer"/>
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
</body>
</html>