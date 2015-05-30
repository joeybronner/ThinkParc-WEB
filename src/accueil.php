<?php
	if(!isset($_SESSION)) {
		session_start();
	}
	include('../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../lang/accueil.fr.php');
	else
		include('../lang/accueil.en.php');
	?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
		<meta charset="utf-8">
		<title>FCT Partners</title>
		<meta name="description" content="">
		<meta name="" content="width=device-width">
		<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/templatemo_main.css">
		<link rel="stylesheet" href="../css/app.css">
		<script src="../js/jquery.min.js"></script>
		<script src="../js/jquery-ui.min.js"></script>
		<script src="../js/jquery.backstretch.min.js"></script>
		<script src="../js/templatemo_script.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script>
			$(function onLoad(){
			   	// If any parameters exists to redirect to a specific section
				var section = getParameterByName('section');
				if (section != "") {
					changeSection("#" + section);
				}
				
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/news/random",  
					success:	function(data) {
									var response = JSON.parse(data);
									var content = '<h6>Posté par ' + response[0].firstname + ' ' + response[0].lastname + ' le ' + response[0].date_news + '</h6>';
									content = content + '<h5>' + response[0].msg + '</h5>';
									document.getElementById("newsContent").innerHTML = content;
								}
				});
			});
			
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
		<div id="main-wrapper">
			<div class="image-section">
				<div class="image-container">
					<img src="../images/background/sky.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
					<img src="../images/background/sky.jpg" id="products-img" class="inactive" alt="Product stocks">
					<img src="../images/background/sky.jpg" id="vehicles-img"  class="inactive" alt="Vehicles">
					<img src="../images/background/sky.jpg" id="about-img" class="inactive" alt="Véhicules">
					<img src="../images/background/sky.jpg" id="contact-img" class="inactive" alt="Contact">
					<img src="../images/background/sky.jpg" id="company-intro-img" class="inactive" alt="Company Intro">
					<img src="../images/background/sky.jpg" id="testimonials-img" class="inactive" alt="Testimonials">
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
									<a href="#about" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-signal"></i>
											<h2>Reporting</h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#contact" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-wrench"></i>
											<h2>Reparation</h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20 pull-right">
									<a href="#company-intro" class="change-section">
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
												<td>Machines transférées</td>
												<td>1</td>
											</tr>
											<tr>
												<td>Machines en maintenance</td>
												<td>3</td>
											</tr>
											<tr>
												<td>Echéance assurance</td>
												<td>3</td>
											</tr>
											<tr>
												<td>Echéance controle technique</td>
												<td>4</td>
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
										<a href="#" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-sign-out"></i>
												<h2>Sorties</h2>
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
										<a href="#" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-edit"></i>
												<h2>Inventaires</h2>
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
						<section id="about-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center"><span class="green"><a href="">Reporting</a></span></h2>
									<div class="col-sm-6 col-md-6">
										<p>Présentation des rapports et bilans analytiques sur les activités et résultats.</p>
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
						<!-- /.about-section -->    
						<section id="contact-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center">Reparations</h2>
									<div class="col-sm-12 col-md-12">
										<p>Cette espace vous permet de gérer les <a href="Reparation.html">réparations</a> des véhicules. Il vous permet aussi de consulter les informations des différents <a href="Garages.html">garages</a>, ainsi que les <a href="PieceRechange.html">pièces de rechanges</a> disponibles. Enfin, vous pouvez accéder aux <a href="Entretiens.html">carnet d'entretiens</a> de ceux-ci</p>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
										<a href="Reparation.html" class="change-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-wrench"></i>
												<h2>Reparations</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
										<a href="Garages.html" class="change-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-flag-checkered"></i>
												<h2>Garages</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
										<a href="PieceRechange.html" class="change-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-recycle"></i>
												<h2>Rechanges</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
										<a href="Entretiens.html" class="change-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-list-alt"></i>
												<h2>Entretiens</h2>
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
						<!-- /.contact-section -->    
						<section id="company-intro-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center">Options</h2>
									<div class="col-sm-12 col-md-12">
										<p> Vous trouverez dans cette rubrique, toutes les options disponibles</p>
									</div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
										<a href="#" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-bookmark-o"></i>
												<h2>Ajout Marque</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="#" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-bookmark"></i>
												<h2>Ajout Modèle</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="#" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-download"></i>
												<h2>Ajout document</h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="#" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-users"></i>
												<h2>Ajout utilisateurs</h2>
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
						<!-- /.company-intor-section -->    
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
					<!-- /.row --> 
				</div>
				<?php include('footer/footer.php'); ?>
			</div>
		</div>
	</body>
</html>