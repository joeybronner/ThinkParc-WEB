<?php
/* ======================================================================== *
 *																			*
 * @filename:		addvehicle.php											*
 * @description:	This page allows a user to add a new vehicle for a		*
 *					specific site in his company.							*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @lastupdate: 	01/05/2015												*
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
			include('../../lang/vehicles/addvehicle.fr.php');
		} else {
			include('../../lang/vehicles/addvehicle.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="addvehicle.js"></script>';
	?>
	<title><?php echo $addvehicle['ADDVEHICLE_TITLE']; ?></title>
</head>
<body>

	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>

	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/vehicles/think_parc_vehicles_3.jpg">

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
				<h2><?php echo $addvehicle['ADDVEHICLE_TITLE']; ?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form id="addvehicle" method="get" action="javascript:addVehicule();">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td width="100%" colspan="2"><h5><?php echo $addvehicle['ADDVEHICLE_BRANDMODEL']; ?></h5></td>
										</tr>
										<tr>
											<td width="50%">
												<select id="brand" name="brand" required="required" class="form-control" onchange="getModels(this.value);">
													<!-- Retrieve brands with an AJAX [GET] query -->
												</select>
											</td>
											<td width="50%">
												<select id="model" name="model" required="required" class="form-control" disabled>
													<option selected disabled><?php echo $addvehicle['ADDVEHICLE_MODEL']; ?></option>
													<!-- Retrieve models with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="2"><h5><?php echo $addvehicle['ADDVEHICLE_KINDCAT']; ?></h5></td>
										</tr>
										<tr>
											<td width="50%">
												<select id="kinds" name="kinds" class="form-control" required>
													<!-- Retrieve kinds with an AJAX [GET] query -->
												</select>
											</td>
											<td width="50%">
												<select id="categories" name="categories" class="form-control" required>
													<!-- Retrieve categories with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="2"><h5><?php echo $addvehicle['ADDVEHICLE_ENERGYEQUIPMENTS']; ?></h5></td>
										</tr>
										<tr>
											<td width="50%">
												<select id="energies" name="energies" class="form-control" required>
													<!-- Retrieve energies with an AJAX [GET] query -->
												</select>
											</td>
											<td width="50%">
												<input class="form-control" type="text" id="equipments" name="equipments" placeholder="<?php echo $addvehicle['SEAVEHICLE_EQUIPMENT']; ?>"/>
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="2"><h5><?php echo $addvehicle['ADDVEHICLE_BUYINGPRICE']; ?></h5></td>
										</tr>
										<tr>
											<td width="50%">
												<input class="form-control" type="number" min="0" step="any" id="buyingprice" name="buyingprice" placeholder="<?php echo $addvehicle['ADDVEHICLE_BUYINGPRICE']; ?>" required/>
											</td>
											<td width="50%">
												<select id="currencies" name="currencies" required="required" class="form-control">
													<!-- Retrieve equipments with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="2"><h5><?php echo $addvehicle['ADDVEHICLE_PLATESERIAL']; ?></h5></td>
										</tr>
										<tr>
											<td width="50%">
												<input class="form-control" type="text" id="nr_plate" name="nr_plate" placeholder="<?php echo $addvehicle['ADDVEHICLE_PLATE']; ?>" required/>
											</td>
											<td width="50%">
												<input class="form-control" type="text" id="nr_serial" name="nr_serial" placeholder="<?php echo $addvehicle['ADDVEHICLE_SERIAL']; ?>" required/>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $addvehicle['ADDVEHICLE_BUYINGDATE']; ?></h5></td>
											<td width="50%">
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_buy" name="date_buy" placeholder="JJ/MM/AAAA" required>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $addvehicle['ADDVEHICLE_FIRSTDATE']; ?></h5></td>
											<td width="50%">
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_entryservice" name="date_entryservice" placeholder="JJ/MM/AAAA" required>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $addvehicle['ADDVEHICLE_MILEAGE']; ?></h5></td>
											<td width="50%">
												<input class="form-control" type="number" min="0" step="any" id="mileage" name="mileage" placeholder="100000" required/>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $addvehicle['ADDVEHICLE_COMMENTARY']; ?></h5></td>
											<td width="50%">
												<textarea class="form-control" rows="5" maxlength="140" id="commentary" name="commentary" placeholder="<?php echo $addvehicle['ADDVEHICLE_COMMENTARY']; ?> "></textarea>
											</td>
										</tr>
										<tr>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $addvehicle['ADDVEHICLE_SITE']; ?></h5></td>
											<td width="50%">
												<select id="sites" name="sites" class="form-control" required>
													<!-- Retrieve sites with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $addvehicle['ADDVEHICLE_STATE']; ?></h5></td>
											<td width="50%">
												<select id="states" name="states" class="form-control" required>
													<!-- Retrieve states with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="right">
												<input type="reset" value="<?php echo $addvehicle['ADDVEHICLE_RESET']; ?>" class="btn btn-warning"/>
												<input type="submit" class="btn btn-success" value="<?php echo $addvehicle['ADDVEHICLE_ADD']; ?>"/>
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