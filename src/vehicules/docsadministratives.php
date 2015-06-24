<?php
/* ======================================================================== *
 *																			*
 * @filename:		docsadministratives.php									*
 * @description:	This page groups all administratives informations 		*
 * 					about a registered vehicle.								*
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
			include('../../lang/vehicles/docsadministratives.fr.php');
		} else {
			include('../../lang/vehicles/docsadministratives.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="docsadministratives.js"></script>';
	?>
	<title>Documents administratifs</title>
</head>
<body>
	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>

	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/vehicles/think_parc_vehicles_6.jpg">

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
				<h2>Détails administratifs de vos véhicules</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tr>
										<td><h5>Veuillez sélectionner un véhicule dans la liste</h5></td>
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
			<div id="administrativeblock" class="black-bg btn-menu margin-bottom-20">
				<h2>Documents administratifs concernant ce véhicule</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<div class="col-md-12 col-lg-12"><table class="table table-user-information">
									<table id="vehicledetail" class="table-no-border">
										<tbody>
											<tr>
												<td style="width:50%;">N° du contrat d'assurance</td>
												<td>
													<input class="form-control" type="text" id="nr_contract" name="nr_contract" required>
												</td>
											</tr>
											<tr>
												<td>Dernier contrôle technique</td>
												<td>
													<input type="text" class="form-control" id="date_lastcontrol" name="date_lastcontrol" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
												</td>
											</tr>
											<tr>
												<td>Prochain contrôle technique</td>
												<td>
													<input type="text" class="form-control" id="date_nextcontrol" name="date_nextcontrol" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
												</td>
											</tr>
											<tr>
												<td>Début du contrat d'assurance</td>
												<td>
													<input type="text" class="form-control" id="date_startinsurance" name="date_startinsurance" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
												</td>
											</tr>
											<tr>
												<td>Fin du contrat d'assurance</td>
												<td>
													<input type="text" class="form-control" id="date_endinsurance" name="date_endinsurance" data-date-format="dd/mm/yyyy" placeholder="JJ/MM/AAAA" required>
												</td>
											</tr>
											<tr>
												<td>Assureurs</td>
												<td>
													<select id="insurances" name="insurances" required class="form-control"></select>
												</td>
												<td align="right">
													<a href="javascript:newinsurancefields();"><i id="insur_choice" class="fa fa fa-sort-up"></i></a>
												</td>
											</tr>
											<tr>
												<td>Nom de l'assureur</td>
												<td>
													<input class="form-control" type="text" id="ins_name" name="ins_name" disabled>
												</td>
											</tr>
											<tr>
												<td>Téléphone</td>
												<td>
													<input class="form-control" type="text" id="ins_phone" name="ins_phone" disabled>
												</td>
											</tr>
											<tr>
												<td>Email</td>
												<td>
													<input class="form-control" type="text" id="ins_email" name="ins_email" disabled>
												</td>
											</tr>
											<tr>
												<td>Adresse (ligne 1)</td>
												<td>
													<input class="form-control" type="text" id="ins_add1" name="ins_add1" disabled>
												</td>
											</tr>
											<tr>
												<td>Adresse (ligne 2)</td>
												<td>
													<input class="form-control" type="text" id="ins_add2" name="ins_add2" disabled>
												</td>
											</tr>
											<tr>
												<td>Adresse (ligne 3)</td>
												<td>
													<input class="form-control" type="text" id="ins_add3" name="ins_add3" disabled>
												</td>
											</tr>
											<tr>
												<td>Code postal</td>
												<td>
													<input class="form-control" type="text" id="ins_zipcode" name="ins_zipcode" disabled>
												</td>
											</tr>
											<tr>
												<td>Ville</td>
												<td>
													<input class="form-control" type="text" id="ins_city" name="ins_city" disabled>
												</td>
											</tr>
											<tr>
												<td>Pays</td>
												<td>
													<input class="form-control" type="text" id="ins_country" name="ins_country" disabled>
												</td>
											</tr>
											<tr>
												<td>
													<input type="button" onclick="javascript:saveAdministrative();" id ="addAdministrative" value="Enregistrer" class="btn btn-success"/>
													<input type="button" onclick="javascript:saveChangesAdministrative();" id ="updateAdministrative" value="Mettre à jour" class="btn btn-success"/>
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