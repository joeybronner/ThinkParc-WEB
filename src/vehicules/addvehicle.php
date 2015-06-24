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
	<title>Ajouter un véhicule</title>
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
						<h5><i class="fa fa-chevron-left"></i> Retour</h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Ajouter un véhicule</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form id="addvehicle" method="get" action="javascript:addVehicule();">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* Marque & Modèle</h5></td>
										</tr>
										<tr>
											<td>
												<select id="brand" name="brand" required="required" class="form-control" onchange="getModels(this.value);">
													<!-- Retrieve brands with an AJAX [GET] query -->
												</select>
											</td>
											<td>
												<select id="model" name="model" required="required" class="form-control" disabled>
													<option selected disabled>Modele du véhicule</option>
													<!-- Retrieve models with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Genre & Catégorie</h5></td>
										</tr>
										<tr>
											<td>
												<select id="kinds" name="kinds" required="required" class="form-control">
													<!-- Retrieve kinds with an AJAX [GET] query -->
												</select>
											</td>
											<td>
												<select id="categories" name="categories" required="required" class="form-control">
													<!-- Retrieve categories with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Energie & Equipements spéciaux</h5></td>
										</tr>
										<tr>
											<td>
												<select id="energies" name="energies" required="required" class="form-control">
													<!-- Retrieve energies with an AJAX [GET] query -->
												</select>
											</td>
											<td>
												<select id="equipments" name="equipments" required="required" class="form-control">
													<!-- Retrieve equipments with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>Prix d'achat</h5></td>
										</tr>
										<tr>
											<td>
												<input class="form-control" type="text" id="buyingprice" name="buyingprice" placeholder="Prix d'achat" required/>
											</td>
											<td>
												<select id="currencies" name="currencies" required="required" class="form-control">
													<!-- Retrieve equipments with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>Matricule & Numéro de série</h5></td>
										</tr>
										<tr>
											<td>
												<input class="form-control" type="text" id="nr_plate" name="nr_plate" placeholder="Matricule"/>
											</td>
											<td>
												<input class="form-control" type="text" id="nr_serial" name="nr_serial" placeholder="Numéro de série"/>
											</td>
										</tr>
										<tr>
											<td><h5>* Date d'achat</h5></td>
											<td>
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_buy" name="date_buy" placeholder="JJ/MM/AAAA" required>
											</td>
										</tr>
										<tr>
											<td><h5>* Date de mise en circulation</h5></td>
											<td>
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_entryservice" name="date_entryservice" placeholder="JJ/MM/AAAA" required>
											</td>
										</tr>
										<tr>
											<td><h5>* Kilométrage</h5></td>
											<td>
												<input class="form-control" type="text" id="mileage" name="mileage" required="required" placeholder="100 000"/>
											</td>
										</tr>
										<tr>
											<td><h5>Commentaires</h5></td>
											<td>
												<textarea class="form-control" rows="5" maxlength="140" id="commentary" name="commentary" placeholder="Commentaires "></textarea>
											</td>
										</tr>
										<tr>
											
										</tr>
										<tr>
											<td><h5>* Site</h5></td>
											<td>
												<select id="sites" name="sites" required="required" class="form-control">
													<!-- Retrieve sites with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Etat</h5></td>
											<td>
												<select id="states" name="states" required="required" class="form-control">
													<!-- Retrieve states with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="right">
												<input type="reset" value="Reinitialiser" class="btn btn-warning"/>
												<input type="submit" class="btn btn-success" value="Enregistrer"/>
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