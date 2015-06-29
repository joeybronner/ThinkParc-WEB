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
			include('../../lang/vehicles/addvehicle.fr.php');
		} else {
			include('../../lang/vehicles/vehicles.en.php');
			include('../../lang/vehicles/addvehicle.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="searchvehicle.js"></script>';
	?>
	<title><?php echo $addvehicle['SEAVEHICLE_TITLE']; ?></title>
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
						<h5><i class="fa fa-chevron-left"></i><?php echo $addvehicle['BACK']; ?></h5>
				</a>
			</div>
		</div>
		<div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $addvehicle['SEAVEHICLE']; ?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tr>
										<td><h5><?php echo $addvehicle['SEAVEHICLE_SELECT']; ?></h5></td>
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
				<h2><?php echo $addvehicle['SEAVEHICLE_INFOSDETAIL']; ?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<div class="col-md-12 col-lg-12">
									<table class="table-no-border">
										<tr>
											<td><?php echo $addvehicle['ADDVEHICLE_PLATE']; ?></td>
											<td>
												<input class="form-control" type="text" id="nr_plate" name="nr_plate" required disabled/>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['ADDVEHICLE_SERIAL']; ?></td>
											<td>
												<input class="form-control" type="text" id="nr_serial" name="nr_serial" required disabled/>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['ADDVEHICLE_BUYINGDATE']; ?></td>
											<td>
												<input class="form-control" type="text" id="date_buy" name="date_buy" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['ADDVEHICLE_FIRSTDATE']; ?></td>
											<td>
												<input class="form-control" type="text" id="date_entryservice" name="date_entryservice" required data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA">
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_BRAND']; ?></td>
											<td>
												<select id="brand" name="brand" required="required" class="form-control"></select>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_MODEL']; ?></td>
											<td>
												<select id="model" name="model" required="required" class="form-control"></select>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_MILEAGE']; ?></td>
											<td>
												<input class="form-control" type="number" min="0" step="any" id="mileage" name="mileage" required>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_ENERGY']; ?></td>
											<td>
												<select id="energies" name="energies" required="required" class="form-control"></select>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_STATE']; ?></td>
											<td>
												<select id="states" name="states" required="required" class="form-control"></select>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_CATEGORY']; ?></td>
											<td>
												<select id="categories" name="categories" required="required" class="form-control"></select>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['ADDVEHICLE_BUYINGPRICE']; ?></td>
											<td>
												<input class="form-control" type="number" min="0" step="any" id="buyingprice" name="buyingprice" required />
												<select id="currencies" name="currencies" required="required" class="form-control"></select>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_TYPE']; ?></td>
											<td>
												<select id="kinds" name="kinds" required="required" class="form-control"></select>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_EQUIPMENT']; ?></td>
											<td>
												<input class="form-control" type="text" id="equipments" name="equipments"/>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['SEAVEHICLE_SITE']; ?></td>
											<td>
												<select id="sites" name="sites" required="required" class="form-control"></select>
											</td>
										</tr>
										<tr>
											<td><?php echo $addvehicle['ADDVEHICLE_COMMENTARY']; ?></td>
											<td>
												<textarea class="form-control" rows="5" maxlength="140" id="commentary" name="commentary" ></textarea>
											</td>
										</tr>
									</table>
								</div>
							</form>
							<input type="button" onclick="javascript:deleteVehicle();" value="<?php echo $addvehicle['SEAVEHICLE_DELETE']; ?>" class="btn btn-danger"/>
							<input type="button" onclick="javascript:saveChangesVehicle();" value="<?php echo $addvehicle['SEAVEHICLE_SAVE']; ?>" class="btn btn-success"/>
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