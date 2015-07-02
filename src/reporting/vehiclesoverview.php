<?php
/* ======================================================================== *
 *																			*
 * @filename:		vehiclesoverview.php									*
 * @description:	Reporting for a specific vehicle between a 				*
 * 					range of date											*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @creation: 		01/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 01/06/2015 | J.BRONNER      | Creation									*
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
			include('../../lang/reporting/vehiclesoverview.fr.php');
		} else {
			include('../../lang/reporting/vehiclesoverview.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="vehiclesoverview.js"></script>';
	?>
	<title><?php echo $vehicloverv['PAGE_TITLE']; ?></title>
</head>
<body>

	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>
	
	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/maintenance/think_parc_maintenance_5.jpg">
	
	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>
	
	<!-- Page content -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad">	
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=reporting">
						<h5><i class="fa fa-chevron-left"></i><?php echo $vehicloverv['BACK']; ?></h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border" width="100%">
									<tbody>
										<tr>
											<td width="25%">
												<?php echo $vehicloverv['VEHICLE']; ?>
											</td>
											<td width="25%">
												<?php echo $vehicloverv['FROM']; ?>
											</td>
											<td width="25%">
												<?php echo $vehicloverv['TO']; ?>
											</td>
											<td width="25%">
												<?php echo $vehicloverv['GROUPING']; ?>
											</td>
										</tr>
										<tr>
											<td width="25%">
												<select id="listvehicles" name="listvehicles" required="required" class="form-control">
													<!-- Retrieve kinds with an AJAX [GET] query -->
												</select>
											</td>
											<td width="25%">
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_start" name="date_start" placeholder="JJ/MM/AAAA" required>
											</td>
											<td width="25%">
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_end" name="date_end" placeholder="JJ/MM/AAAA" required>
											</td>
											<td width="20%">
												<select id="filter" name="filter" class="form-control">
													<option value="DAY"><?php echo $vehicloverv['DAY']; ?></option>
													<option value="MONTH"><?php echo $vehicloverv['MONTH']; ?></option>
													<option value="YEAR"><?php echo $vehicloverv['YEAR']; ?></option>
												</select>
											</td>
											<td width="5%" align="right">
												<a href="javascript:refreshReport();">
													<i class="fa fa-search"></i>
												</a>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table-no-border" width="100%">
									<thead>
										<tr id="chart1">
											<td id="availablemaintenancedays" width="33%" align="center" style="height: auto;">
												
											</td>
											<td id="partsused" width="33%" align="center" style="height: auto;">
												
											</td>
											<td id="typemaintenance" width="33%" align="center" style="height: auto;">
												
											</td>
										</tr>
									</thead>
									<tbody>
										<tr id="chart2">
											<td id="maintenancecost" width="100%" style="max-height:500px;" colspan="3">
												
											</td>
										</tr>
										<tr id="chart3">
											<td id="maintenanceparts" width="100%" style="max-height:500px;" colspan="3">
												
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
	<!-- End page content -->
	
	<!-- Include footer bar with language switch & global website informations -->
	<?php require(BASE_PATH . '/src/footer/footer.php'); ?>
</body>
</html>