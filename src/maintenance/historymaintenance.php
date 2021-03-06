<?php
/* ======================================================================== *
 *																			*
 * @filename:		historymaintenance.php									*
 * @description:	This page display an history of maintenance				*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @lastupdate: 	05/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 16/06/2015 | J.BRONNER      | Creation									*
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
			include('../../lang/maintenance/maintenance.fr.php');
		} else {
			include('../../lang/maintenance/maintenance.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="historymaintenance.js"></script>';
	?>
	<title><?php echo $maintenance['PAGE_TITLE'];?></title>
</head>
<body>

	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>
	
	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>
	
	<!-- Background image for this page-->
	<img src="../../images/background/maintenance/think_parc_maintenance_7.jpg" id="menu-img" class="main-img inactive">
	
	<!-- Page content -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad">	
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=maintenance">
						<h5><i class="fa fa-chevron-left"></i><?php echo $maintenance['BACK'];?></h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td width="50%">
												<h2><?php echo $maintenance['HISTORY'];?></h2>
											</td>
											<td width="50%">
												<select id="listvehicles" name="listvehicles" class="form-control" onchange="javascript:showMaintenanceHistoryForSpecificVehicle(this.value);">
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
			<div id="maintenancedetails" class="black-bg btn-menu" style="display:none;">
				<h2><?php echo $maintenance['HISTORY_OVERVIEW']; ?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td>
												<center><h2><?php echo $maintenance['HISTORY_DAYS_STATUS']; ?></h2></center>
											</td>
										</tr>
										<tr>
											<td width="100%" align="center" id="donutchart" style="height:200px;">
												<!-- Google Donut chart to vizualize the number of days in maintenance / available -->
											</td>
										</tr>
										<tr>
											<td width="100%">
												<table width="100%" id="maintenancestable" class="partstable">
													<tr>
														<td width="15%" class="part_title"><?php echo $maintenance['HISTORY_TABLE_START']; ?></td>
														<td width="15%" class="part_title"><?php echo $maintenance['HISTORY_TABLE_END']; ?></td>
														<td width="20%" class="part_title"><?php echo $maintenance['HISTORY_TABLE_TYPE']; ?></td>
														<td width="15%" class="part_title"><?php echo $maintenance['HISTORY_TABLE_LABOUR_HOUR']; ?></td>
														<td width="15%" class="part_title"><?php echo $maintenance['HISTORY_TABLE_LABOUR_RATE']; ?></td>
														<td width="10%" height="38px" class="part_title"><i class="fa fa-eraser"></i></td>
														<td width="10%" height="38px" class="part_title"><i class="fa fa-search"></i></td>
													</tr>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="partsdetails" class="black-bg btn-menu margin-bottom-20" style="display:none;">
				<h2><?php echo $maintenance['HISTORY_PARTS_DETAIL']; ?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<div class="col-md-12 col-lg-12">
									<div id="parts">
									</div>
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