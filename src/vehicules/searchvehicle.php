<?php
/* ======================================================================== *
 *																			*
 * @filename:		searchvehicle.php										*
 * @description:	This page retrieves all informations about a specific	*
 *					vehicle (with plate nr)									*
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
			include('../../lang/vehicles/vehicles.fr.php');
		} else {
			include('../../lang/vehicles/vehicles.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="searchvehicle.js"></script>';
	?>
	<title>Recherche de véhicule</title>
</head>
<body>
	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>

	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/vehicles/think_parc_vehicles_4.jpg">

	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>
	
	<!-- Page content -->
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
				<h2><?php echo $lang['CONSULT_EDIT_VEHICLE_TITLE']; ?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tr>
										<td><h5><?php echo $lang['SELECT_VEHICLE_LIST']; ?></h5></td>
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
				<h2><?php echo $lang['INFOS_DETAIL']; ?></h2>
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
				<h2><?php echo $lang['FILES_LIST']; ?></h2>
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
									<button type="submit" id="upload-button" class="btn btn-success"><?php echo $lang['ADD_FILE']; ?></button>
								</td>
							</tr>
						</table>
				</form>
			</div>
		</div>
	</div>
	<!-- End page content -->
	
	<!-- Include footer bar with language switch & global website informations -->
	<?php require(BASE_PATH . '/src/footer/footer.php'); ?>
   </body>
</html>