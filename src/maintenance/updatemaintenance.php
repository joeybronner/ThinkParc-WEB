<?php
/* ======================================================================== *
 *																			*
 * @filename:		updatemaintenance.php									*
 * @description:	This page allows a user to update the maintenance 		*
 *					status (add parts, update dates etc...)					*
 *					It's the same form like "addmaintenance" page. 			*
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
		echo '<script type="text/javascript" src="updatemaintenance.js"></script>';
	?>
	<title><?php echo $maintenance['PAGE_TITLE'];?></title>
</head>
<body>

	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>

	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/maintenance/think_parc_maintenance_4.jpg">

	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>
	
	<!-- Page content -->
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=maintenance">
						<h5><i class="fa fa-chevron-left"></i><?php echo $maintenance['BACK'];?></h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $maintenance['UPDATE_VEHICLE_TITLE'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td width="50%"><h5><?php echo $maintenance['VEHICLE'];?></h5></td>
											<td width="50%">
												<select id="listvehicles" name="listvehicles" class="form-control" onchange="javascript:showMaintenanceDetails(this.value);">
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
			<div id="maintenancedetails" class="black-bg btn-menu margin-bottom-20" style="display:none;">
				<h2><?php echo $maintenance['MAINTENANCE_DETAILS'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td width="50%"><h5><?php echo $maintenance['TYPE_MAINTENANCE'];?></h5></td>
											<td colspan="2" width="50%">
												<select id="typemaintenance" name="typemaintenance" class="form-control" disabled>
													<!-- Retrieve types of maintenance with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $maintenance['START_MAINTENANCE'];?></h5></td>
											<td colspan="2" width="50%">
												<input data-format="yyyy-mm-dd" class="form-control" type="date" id="date_startmaintenance" disabled />
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $maintenance['END_MAINTENANCE'];?></h5></td>
											<td colspan="2" width="50%">
												<input data-format="yyyy-mm-dd" class="form-control" type="date" id="date_endmaintenance" />
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="3" align="right">
												<h5>
													<a href="javascript:popup('custompopup');">
														<input type="button" value="<?php echo $maintenance['ADD_PART'];?>" class="btn btn-normal" />
													</a>
												</h5>
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="3">
												<table id="partstable" class="partstable">
													<tr>
														<td width="20%" class="part_title"><?php echo $maintenance['TABLE_REFERENCE'];?></td>
														<td width="30%" class="part_title"><?php echo $maintenance['TABLE_DESCRIPTION'];?></td>
														<td width="10%" class="part_title"><?php echo $maintenance['TABLE_QUANTITY'];?></td>
														<td width="15%" class="part_title"><?php echo $maintenance['TABLE_STOCKID'];?></td>
														<td width="15%" class="part_title"><?php echo $maintenance['TABLE_UNITPRICE'];?></td>
														<td width="10%" height="38px" class="part_title"><i class="fa fa-eraser"></i></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $maintenance['LABOUR_HOURS'];?></h5></td>
											<td width="50%" style="padding-top:25px;" colspan="2">
												<input type="number" min="0" class="form-control" id="labour_hours" value="0" step="any"/>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $maintenance['LABOUR_HOURLYRATE'];?></h5></td>
											<td width="30%">
												<input type="number" min="0" class="form-control" id="labour_hourlyrate" value="0" step="any"/>
											</td>
											<td width="20%">
												<select id="currencies" name="currencies" class="form-control">
													<!-- Retrieve equipments with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td width="50%"><h5><?php echo $maintenance['COMMENTARY'];?></h5></td>
											<td colspan="2" width="50%">
												<textarea id="commentary" class="form-control" rows="3" maxlength="255"></textarea>
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="3" align="right" style="padding-top:25px;text-align:center;">
												<input type="button" value="<?php echo $maintenance['DELETE_MAINTENANCE'];?>" class="btn btn-danger" onclick="javascript:deleteMaintenance()"/>
												<input type="button" value="<?php echo $maintenance['UPDATE_MAINTENANCE'];?>" class="btn btn-success" onclick="javascript:updateMaintenance()"/>
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
	
	<!-- PopUp section -->
	<div id="blanket" style="display:none"></div>
	<div id="custompopup" style="display:none">
			<div class="panel-body"  style="padding:30px;">
				<div class="row"> 
						<form id="addmaintenance" action="javascript:addParts();">
							<table style="width:100%;">
								<tbody>
									<tr>
										<td><h5><?php echo $maintenance['PART_REFERENCE'];?></h5></td>
										<td>
											<input class="form-control" type="text" id="reference" name="reference" placeholder="Reference" onkeyup="valuesChanges()" />
										</td>
									</tr>
									<tr>
										<td><h5><?php echo $maintenance['QUANTITY'];?></h5></td>
										<td>
											<input class="form-control" type="number" min="0" value="1" id="quantity" name="quantity" onkeyup="valuesChanges()" />
										</td>
									</tr>
									<tr>
										<td id="stockstatus" colspan="2">
											<center>
												<table> 
													<tbody id="stockcontent" style="display:block; height:250px; overflow-y:auto;">
														<!-- Stock content -->
													</tbody>
												</table>
											</center>
										</td>
									</tr>
									<tr>
										<td colspan="2" align="right">
											<input type="button" class="btn btn-danger" onclick="javascript:cancelAddPart();" value="<?php echo $maintenance['BT_CANCEL'];?>"/>
											<input type="submit" class="btn btn-success" value="<?php echo $maintenance['BT_ADD'];?>"/>
										</td>
									</tr>
								</tbody>
							</table>
						</form>
				</div>
			</div>
	</div>
	<!-- End PopUp section -->
	
	<!-- Include footer bar with language switch & global website informations -->
	<?php require(BASE_PATH . '/src/footer/footer.php'); ?>
</body>
</html>