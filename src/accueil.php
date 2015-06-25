<?php
/* ======================================================================== *
 *																			*
 * @filename:		accueil.php												*
 * @description:	Home page for Think-Parc website.						*
 *					Here you'll find all links and modules implemented		*
 *																			*
 * @author(s): 		Joey BRONNER & Saïd KHALID								*
 * @contact(s):		joeybronner@gmail.com ; khalidsaid.box@gmail.com		*
 * @lastupdate: 	01/02/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 01/02/2015 | JBR ; SKH      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/
?>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php
		if(!isset($_SESSION)) {
			session_start();
		}
		
		/* 1. Import contants values with DIR path used for future imports */
		require('header/constants.php');
		
		/* 2. Check session's state and authentication */
		require(BASE_PATH . '/db/check_session.php');
		
		/* 3. Include CSS (design) & JS (features) files */
		require(BASE_PATH . '/src/header/cssandjsfiles.php');
		
		/* 4. Import language values: French or English files */
		if($_SESSION['fct_lang'] == 'FR') {
			include('../lang/accueil.fr.php');
		} else {
			include('../lang/accueil.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		// echo '<script type="text/javascript" src="addvehicle.js"></script>';

	?>
		<title>Think-Parc | Home</title>
		<script>			
			/** AngularJS module for HTTP requests */
			angular.module('HomeModule', []).controller('HomeController', function ($scope, $http) {
				$scope.getRandomNews = function (data) {
					$http.get('http://think-parc.com/webservice/v1/news/random').
						success(function(data, status, headers, config) {
							var response = angular.fromJson(data);
							var content = '<h6>Posté par ' + response[0].firstname + ' ' + response[0].lastname + ' le ' + reformatDate(response[0].date_news) + '</h6>';
							content = content + '<h5>' + response[0].msg + '</h5>';
							document.getElementById("newsContent").innerHTML = content;
						});
				};
			});
			
			$(function onLoad(){
			   	// If any parameters exists to redirect to a specific section
				var section = getParameterByName('section');
				if (section != "") {
					changeSection("#" + section);
				}
				/* Load random news */
				angular.element($("#main-wrapper")).scope().getRandomNews();
				
				/* Load QuickView values */
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all",  
						success:	function(data) {
										var response1 = JSON.parse(data);
										var totalvehicles = response1.length;
										$.ajax({
											method: 	"GET",
											url:		"http://think-parc.com/webservice/v1/companies/" + company + "/reporting/vehicles/currentlyinmaintenance",  
											success:	function(data) {
															var response2 = JSON.parse(data);
															var vehiclesmaintenance = response2.length;
															document.getElementById("qv_vehicles_maint").innerHTML = vehiclesmaintenance + "/" + totalvehicles;
															if ((vehiclesmaintenance/totalvehicles)*100 > 50) {
																document.getElementById("qv_vehicles_maint").style.color='red';
															} else if ((vehiclesmaintenance/totalvehicles)*100 > 10) {
																document.getElementById("qv_vehicles_maint").style.color='orange';
															} else {
																document.getElementById("qv_vehicles_maint").style.color='green';
															}
														}
										});
									}
					});
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/stocks/gettransferlist/company/" + company, 
						success:	function(data) {				
										var response = JSON.parse(data);										
										document.getElementById("qv_transfert_wait").innerHTML = response.length;
										if (response.length > 0) {
											document.getElementById("qv_transfert_wait").style.color='red';
										} else {
											document.getElementById("qv_transfert_wait").style.color='green';
										}
									}
					});
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/reporting/insurances/alert", 
						success:	function(data) {				
										var response = JSON.parse(data);										
										document.getElementById("qv_assurances_end").innerHTML = response.length;
										if (response.length > 0) {
											document.getElementById("qv_assurances_end").style.color='red';
										} else {
											document.getElementById("qv_assurances_end").style.color='green';
										}
									}
					});
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/reporting/technicalcontrol/alert", 
						success:	function(data) {				
										var response = JSON.parse(data);										
										document.getElementById("qv_techcontrol_end").innerHTML = response.length;
										if (response.length > 0) {
											document.getElementById("qv_techcontrol_end").style.color='red';
										} else {
											document.getElementById("qv_techcontrol_end").style.color='green';
										}
									}
					});
				});
			});
			
			/** Good date format JJ/MM/AAAA */
			function reformatDate(dateStr) {
			  dArr = dateStr.split("-");
			  return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
			}
			
			/** Retrieves company's ID */
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
			
			/** Retrieves parameter on page loading (performed with back button) */
			function getParameterByName(name) {
				name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
				var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
					results = regex.exec(location.search);
				return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
			}
		</script>
	</head>
	<body>
		<?php include('header/navbar.php'); ?>
		<div id="main-wrapper" ng-app='HomeModule' ng-controller="HomeController">
			<div class="image-section">
				<div class="image-container">
					<img src="../images/background/home/think_parc_home_1.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
					<img src="../images/background/home/think_parc_home_2.jpg" id="products-img" class="inactive" alt="Product stocks">
					<img src="../images/background/home/think_parc_home_3.jpg" id="vehicles-img"  class="inactive" alt="Vehicles">
					<img src="../images/background/home/think_parc_home_1.jpg" id="reporting-img" class="inactive" alt="Reporting">
					<img src="../images/background/maintenance/think_parc_maintenance_3.jpg" id="maintenance-img" class="inactive" alt="maintenance">
					<img src="../images/background/home/think_parc_home_3.jpg" id="options-img" class="inactive" alt="options">
					<img src="../images/background/home/think_parc_home_1.jpg" id="testimonials-img" class="inactive" alt="Testimonials">
				</div>
			</div>
			<div class="container">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 templatemo-content-wrapper">
					<div class="templatemo-content">
						<section id="menu-section" class="active">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20">
									<div class="black-bg btn-menu">
										<i class="fa fa-users white"></i>
										<h2>News</h2>
										<div id="newsContent" style="width:60%;margin:auto;">
											<!-- Here are loaded news -->
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#products" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-cubes"></i>
											<h2>Stocks</h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#vehicles" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-car"></i>
											<h2>Véhicules</h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#maintenance" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-wrench"></i>
											<h2>Maintenance</h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#reporting" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-signal"></i>
											<h2>Reporting</h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20 pull-right">
									<a href="#options" class="change-section">
										<div class="black-bg btn-menu">
											<h2>Options</h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20 text-center">
									<a href="documents/documents.php" class="directlink-section">
										<div class="black-bg btn-menu">
											<h2>Documents</h2>
										</div>
									</a>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 margin-bottom-20 text-center">
									<div class="black-bg btn-menu">
										<h2>Vue rapide</h2>
										<table>
											<tr>
												<td>Véhicule(s) en maintenance</td>
												<td id="qv_vehicles_maint" align="center">-</td>
											</tr>
											<tr>
												<td>Réception(s) en attente</td>
												<td id="qv_transfert_wait" align="center">-</td>
											</tr>
											<tr>
												<td>Echéance(s) assurances</td>
												<td id="qv_assurances_end" align="center">-</td>
											</tr>
											<tr>
												<td>Echéance(s) contrôles techniques</td>
												<td id="qv_techcontrol_end" align="center">-</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</section>
						<!-- /.menu-section -->    
						<section id="products-section" class="inactive" >
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center">Gestions des stocks</h2>
									<div class="col-sm-12 col-md-12">
										<p>Cette espace vous permet de gérer les <a href="Reparation.html">stocks</a> de produits. Il vous permet aussi les consulter</p>
									</div>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/consultationproduct.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-eye"></i>
												<h2>Consultation</h2>
											</div>
											<br/>
										</a>
									</div>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/addinstock.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-plus"></i>
												<h2>Ajout stock</h2>
											</div>
											<br/>
										</a>
									</div>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/addproduct.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-sign-in"></i>
												<h2>Ajout produit</h2>
											</div>
											<br/>
										</a>
									</div>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/history.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-sign-out"></i>
												<h2>Historiques</h2>
											</div>
											<br/>
										</a>
									</div>
								
									</a>
								
									</a>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/transfert.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-random"></i>
												<h2>Transferts</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
										<a href="stocks/reception.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-edit"></i>
												<h2>Récéptions</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2>Retour au menu</h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<section id="vehicles-section" class="inactive">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-sm-12 col-md-12 col-lg-12 black-bg">
										<h2 class="text-center">Parc automobile</h2>
										<p>Gestion du parc de véhicules</p>
										<?php
											// Privilège destiné uniquement aux administrateurs
											if ($_SESSION['fct_id_role']==1) 
											{
											?>
										<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
											<a href="vehicules/addvehicle.php" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-car"></i>
													<h2>Ajouter<br>un véhicule</h2>
												</div>
											</a>
										</div>
										<?php
											}
											?>
										<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
											<a href="vehicules/searchvehicle.php" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-edit"></i>
													<h2>Consulter<br>un véhicule</h2>
												</div>
											</a>
										</div>
										<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
											<a href="vehicules/docsadministratives.php" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-file"></i>
													<h2>Gérer les docs<br>administratifs</h2>
												</div>
											</a>
										</div>
										<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
											<a href="vehicules/vehiclesanddrivers.php" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-user"></i>
													<h2>Conducteurs<br>des véhicules</h2>
												</div>
											</a>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20">
											<a href="vehicules/vehicles.php" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-search"></i>
													<h2>Voir tous les véhicules</h2>
												</div>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2>Retour au menu</h2>
										</div>
									</a>
								</div>
							</div>
						</section> 
						<section id="reporting-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center">Reporting</h2>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
										<a href="reporting/partsconsumption.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-refresh"></i>
												<h2>Consommation<br>des pièces</h2>
											</div>
										</a>
									</div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2>Retour au menu</h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<section id="maintenance-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center">Maintenance</h2>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20">
										<a href="maintenance/addmaintenance.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-wrench"></i>
												<h2>Nouvelle<br>maintenance</h2>
											</div>
										</a>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
										<a href="maintenance/updatemaintenance.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-repeat"></i>
												<h2>Mise à jour<br>maintenance</h2>
											</div>
										</a>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 margin-bottom-20">
										<a href="maintenance/historymaintenance.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-history"></i>
												<h2>Historique<br>maintenance</h2>
											</div>
										</a>
									</div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2>Retour au menu</h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<section id="options-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center">Options</h2>
									<div class="col-sm-12 col-md-12">
										<p> Vous trouverez dans cette rubrique, toutes les options disponibles</p>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
										<a href="options/addbrand.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-bookmark-o"></i>
												<h2>Ajout Marque</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="options/addmodel.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-bookmark"></i>
												<h2>Ajout Modèle</h2>
											</div>
											<br/>
									</div>
									</a>
									
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="options/adduser.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-users"></i>
												<h2>Ajout utilisateurs</h2>
											</div>
											<br/>
									</div>
									</a>
									
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="options/addsite.php" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-building"></i>
												<h2>Ajout site</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2>Retour au menu</h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<section id="testimonials-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center">Documents Techniques</h2>
									<div class="col-sm-12 col-md-12">
										<p>Vous trouverez dans cette rubrique, tous les documents techniques nécessaire à la prise en main du logiciel</p>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
										<a href="#">
											<div class="black-bg btn-menu">
												<i class="fa fa-wrench"></i>
												<h2>Documents techniques machines</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="documents/docstechniquesvehicules.php">
											<div class="black-bg btn-menu">
												<i class="fa fa-flag-checkered"></i>
												<h2>Documents techniques véhicules</h2>
											</div>
										</a>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="#">
											<div class="black-bg btn-menu">
												<i class="fa fa-recycle"></i>
												<h2>Documents techniques FCT Software</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="#">
											<div class="black-bg btn-menu">
												<i class="fa fa-list-alt"></i>
												<h2>Autres documents format PDF</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2>Retour au menu</h2>
										</div>
									</a>
								</div>
							</div>
						</section>
					</div>
				</div>
				<?php include('footer/footer.php'); ?>
			</div>
		</div>
	</body>
</html>