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
		echo '<script type="text/javascript" src="accueil.js"></script>';

	?>
		<title>Think-Parc | Home</title>
	</head>
	<body>
		<!-- Include navbar with home, informations & logout shortcuts -->
		<?php require(BASE_PATH . '/src/header/navbar.php'); ?>

		<!-- Background images for all pages (Zoom template) -->
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
			<!-- Hidden div(s) for JS values -->
			<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>

			<!-- Global home dashboard (stocks, vehicles, reporting, maintenance, settings, documents...) -->
			<div class="container">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 templatemo-content-wrapper">
					<div class="templatemo-content">
						<section id="menu-section" class="active">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20">
									<div class="black-bg btn-menu">
										<i class="fa fa-users white"></i>
										<h2><?php echo $home['NEWS']; ?></h2>
										<div id="newsContent" style="width:60%;margin:auto;">
											<!-- Here are loaded news -->
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#products" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-cubes"></i>
											<h2><?php echo $home['STOCKS']; ?></h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#vehicles" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-car"></i>
											<h2><?php echo $home['VEHICLES']; ?></h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#maintenance" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-wrench"></i>
											<h2><?php echo $home['MAINTENANCE']; ?></h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
									<a href="#reporting" class="change-section">
										<div class="black-bg btn-menu">
											<i class="fa fa-signal"></i>
											<h2><?php echo $home['REPORTING']; ?></h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20 pull-right">
									<a href="#options" class="change-section">
										<div class="black-bg btn-menu">
											<h2><?php echo $home['OPTIONS']; ?></h2>
										</div>
									</a>
								</div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20 text-center">
									<a href="documents/documents" class="directlink-section">
										<div class="black-bg btn-menu">
											<h2><?php echo $home['DOCUMENTS']; ?></h2>
										</div>
									</a>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 margin-bottom-20 text-center">
									<div class="black-bg btn-menu">
										<h2><?php echo $home['QUICK_VIEW']; ?></h2>
										<table>
											<tr>
												<td width="80%"><?php echo $home['VEHICLES_MAINTENANCE']; ?></td>
												<td width="20%" id="qv_vehicles_maint" align="center">-</td>
											</tr>
											<tr>
												<td width="80%"><?php echo $home['PENDING_TRANSFERT']; ?></td>
												<td width="20%" id="qv_transfert_wait" align="center">-</td>
											</tr>
											<tr>
												<td width="80%"><?php echo $home['TERM_INSURANCE']; ?></td>
												<td width="20%" id="qv_assurances_end" align="center">-</td>
											</tr>
											<tr>
												<td width="80%"><?php echo $home['TERM_CT']; ?></td>
												<td width="20%" id="qv_techcontrol_end" align="center">-</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</section>
						<!-- End global -->

						<!-- Section stock -->    
						<section id="products-section" class="inactive" >
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center"><?php echo $home['STOCK_MANAGEMENT']; ?></h2>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/consultationproduct" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-eye"></i>
												<h2><?php echo $home['STOCK_SEARCH']; ?></h2>
											</div>
											<br/>
										</a>
									</div>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/addinstock" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-plus"></i>
												<h2><?php echo $home['STOCK_ADD']; ?></h2>
											</div>
											<br/>
										</a>
									</div>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/addproduct" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-sign-in"></i>
												<h2><?php echo $home['STOCK_ADD_PRODUCT']; ?></h2>
											</div>
											<br/>
										</a>
									</div>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/history" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-sign-out"></i>
												<h2><?php echo $home['STOCK_HISTORY']; ?></h2>
											</div>
											<br/>
										</a>
									</div>
								
									</a>
								
									</a>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 ">
										<a href="stocks/transfert" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-random"></i>
												<h2><?php echo $home['STOCK_TRANSFERTS']; ?></h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
										<a href="stocks/reception" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-edit"></i>
												<h2><?php echo $home['STOCK_RECEIPT']; ?></h2>
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
											<h2><?php echo $home['BACK_MENU']; ?></h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<!-- End section stock -->

						<!-- Section vehicles -->
						<section id="vehicles-section" class="inactive">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-sm-12 col-md-12 col-lg-12 black-bg">
										<h2 class="text-center"><?php echo $home['VEHICLES_PARK']; ?></h2>
										<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
											<a href="vehicules/addvehicle" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-car"></i>
													<h2><?php echo $home['VEHICLES_ADD']; ?></h2>
												</div>
											</a>
										</div>
										<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
											<a href="vehicules/searchvehicle" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-edit"></i>
													<h2><?php echo $home['VEHICLES_SEARCH']; ?></h2>
												</div>
											</a>
										</div>
										<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
											<a href="vehicules/docsadministratives" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-file"></i>
													<h2><?php echo $home['VEHICLES_ADMDOCS']; ?></h2>
												</div>
											</a>
										</div>
										<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
											<a href="vehicules/vehiclesanddrivers" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-user"></i>
													<h2><?php echo $home['VEHICLES_DRIVERS']; ?></h2>
												</div>
											</a>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20">
											<a href="vehicules/vehicles" class="directlink-section">
												<div class="black-bg btn-menu">
													<i class="fa fa-search"></i>
													<h2><?php echo $home['VEHICLES_ALL']; ?></h2>
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
											<h2><?php echo $home['BACK_MENU']; ?></h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<!-- End section vehicles -->

						<!-- Section reporting -->
						<section id="reporting-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center"><?php echo $home['REPORTING']; ?></h2>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 margin-bottom-20">
										<a href="reporting/partsconsumption" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-cubes"></i>
												<h2><?php echo $home['REPORTING_PARTS']; ?></h2>
											</div>
										</a>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 margin-bottom-20">
										<a href="reporting/vehiclesoverview" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-car"></i>
												<h2><?php echo $home['REPORTING_VEHICLES']; ?></h2>
											</div>
										</a>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20">
										<a href="reporting/globalreporting" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-building"></i>
												<h2><?php echo $home['REPORTING_GLOBAL']; ?></h2>
											</div>
										</a>
									</div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2><?php echo $home['BACK_MENU']; ?></h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<!-- End section reporting -->

						<!-- Section maintenance -->
						<section id="maintenance-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center"><?php echo $home['MAINTENANCE']; ?></h2>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-20">
										<a href="maintenance/addmaintenance" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-wrench"></i>
												<h2><?php echo $home['MAINTENANCE_NEW']; ?></h2>
											</div>
										</a>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
										<a href="maintenance/updatemaintenance" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-repeat"></i>
												<h2><?php echo $home['MAINTENANCE_UPDATE']; ?></h2>
											</div>
										</a>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 margin-bottom-20">
										<a href="maintenance/historymaintenance" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-history"></i>
												<h2><?php echo $home['MAINTENANCE_HISTORY']; ?></h2>
											</div>
										</a>
									</div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2><?php echo $home['BACK_MENU']; ?></h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<!-- End section maintenance -->

						<!-- Section options -->
						<section id="options-section" class="inactive">
							<div class="row">
								<div class="black-bg col-sm-12 col-md-12 col-lg-12">
									<h2 class="text-center"><?php echo $home['OPTIONS']; ?></h2>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
										<a href="options/addbrand" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-bookmark-o"></i>
												<h2><?php echo $home['OPTIONS_BRAND']; ?></h2>
											</div>
											<br/>
									</div>
									</a>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
										<a href="options/addmodel" class="directlink-section">
											<div class="black-bg btn-menu">
												<i class="fa fa-bookmark"></i>
												<h2><?php echo $home['OPTIONS_MODEL']; ?></h2>
											</div>
											<br/>
									</div>
									</a>
									<?php
										if ($_SESSION['fct_id_role']==1) {
									?>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<a href="options/adduser" class="directlink-section">
													<div class="black-bg btn-menu">
														<i class="fa fa-users"></i>
														<h2><?php echo $home['OPTIONS_USER']; ?></h2>
													</div>
													<br/>
												</div>
											</a>
											<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
												<a href="options/addsite" class="directlink-section">
													<div class="black-bg btn-menu">
														<i class="fa fa-building"></i>
														<h2><?php echo $home['OPTIONS_SITE']; ?></h2>
													</div>
													<br/>
												</div>
											</a>
									<?php
										}
									?>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="row margin-top-20">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
									<a href="#menu" class="change-section">
										<div class="black-bg btn-menu">
											<h2><?php echo $home['BACK_MENU']; ?></h2>
										</div>
									</a>
								</div>
							</div>
						</section>
						<!-- End section options -->
					</div>
				</div>
				
				<!-- Include footer bar with language switch & global website informations -->
				<?php require(BASE_PATH . '/src/footer/footer.php'); ?>
			</div>
		</div>
	</body>
</html>