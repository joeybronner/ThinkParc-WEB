<?php
/* ======================================================================== *
 *																			*
 * @filename:		vehiclesanddrivers.php									*
 * @description:	This page groups vehicles and affected drivers 			*
 *					during a period. (with driving licences nr, names		*
 *					and start/end dates)									*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @lastupdate: 	05/05/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 05/05/2015 | J.BRONNER      | Creation									*
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
		require('../header/constants.php');
		
		/* 2. Check session's state and authentication */
		require(BASE_PATH . '/db/check_session.php');
		
		/* 3. Include CSS (design) & JS (features) files */
		require(BASE_PATH . '/src/header/cssandjsfiles.php');
		
		/* 4. Import language values: French or English files */
		if($_SESSION['fct_lang'] == 'FR') {
			include('../../lang/vehicles/vehiclesanddrivers.fr.php');
		} else {
			include('../../lang/vehicles/vehiclesanddrivers.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="vehiclesanddrivers.js"></script>';
	?>
	<title><?php echo $vehanddri['PAGE_TITLE']; ?></title>
</head>
<body>

	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>

	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/vehicles/think_parc_vehicles_1.jpg">

	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>
	
	<!-- Page content -->
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=vehicles">
						<h5><i class="fa fa-chevron-left"></i><?php echo $vehanddri['BACK']; ?></h5>
				</a>
			</div>
		</div>
		<div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $vehanddri['VEHICLESANDDRIVERS']; ?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tr>
										<td><h5><?php echo $vehanddri['SELECT_VEHICLE']; ?></h5></td>
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
				<h2><?php echo $vehanddri['HISTORY']; ?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<div class="col-md-12 col-lg-12">
									<table id="vehicledetail" class="table-no-border">
										<tbody>
											<tr>
												<td><?php echo $vehanddri['DRIVERS_HISTORY']; ?></td>
											</tr>
											<tr>
												<td id="drivers">
													
												</td>
											</tr>
											<tr id="btshowfields">
												<td>
													<a href="javascript:showAddDriverFields();"><i id="add" class="fa fa-plus-circle"></i>
														<?php echo $vehanddri['ADD_DRIVER']; ?>
													</a>
												</td>
											</tr>
										</tbody>
									</table>
									<table id="addentry" class="table-no-border">
										<tbody>
											<tr>
												<td><?php echo $vehanddri['DRIVERS']; ?></td>
												<td>
													<select id="listdrivers" name="listdrivers" required class="form-control"></select>
												</td>
												<td align="right">
													<a href="javascript:newDriverFields();"><i id="driver_choice" class="fa fa-sort-down"></i></a>
												</td>
											</tr>
											<tr>
												<td><?php echo $vehanddri['FIRSTNAME']; ?></td>
												<td>
													<input class="form-control" type="text" id="firstname" name="firstname" disabled>
												</td>
											</tr>
											<tr>
												<td><?php echo $vehanddri['LASTNAME']; ?></td>
												<td>
													<input class="form-control" type="text" id="lastname" name="lastname" disabled>
												</td>
											</tr>
											<tr>
												<td><?php echo $vehanddri['DRIVINGLICENCE']; ?></td>
												<td>
													<input class="form-control" type="text" id="nr_drivinglicence" name="nr_drivinglicence" disabled>
												</td>
											</tr>
											<tr>
												<td><?php echo $vehanddri['DL_DELIVERY']; ?></td>
												<td>
													<input type="text" class="form-control" id="acquisition_drivinglicence" name="acquisition_drinvinglicence" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required disabled>
												</td>
											</tr>
											<tr>
												<td><?php echo $vehanddri['DL_EXPIRE']; ?></td>
												<td>
													<input type="text" class="form-control" id="expire_drivinglicence" name="expire_drinvinglicence" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required disabled>
												</td>
											</tr>
											<tr>
												<td><?php echo $vehanddri['DATE_START']; ?></td>
												<td>
													<input type="text" class="form-control" id="date_start" name="date_start" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
												</td>
											</tr>
											<tr>
												<td><?php echo $vehanddri['DATE_END']; ?></td>
												<td>
													<input type="text" class="form-control" id="date_end" name="date_end" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
												</td>
											</tr>
											<tr>
												<td>
													<input type="button" onclick="javascript:addEntry();" value="<?php echo $vehanddri['BT_ADD']; ?>" class="btn btn-success"/>
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
	<!-- End page content -->
	
	<!-- Include footer bar with language switch & global website informations -->
	<?php require(BASE_PATH . '/src/footer/footer.php'); ?>
   </body>
</html>