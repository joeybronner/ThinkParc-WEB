<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
?>

<html>
<head>
	<meta charset="utf-8" />
	<title>Enregistrer un machine </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/templatemo_main.css">
	<link rel="stylesheet" href="../../css/app.css">
	<script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery.backstretch.min.js"></script>
	<script src="../../js/templatemo_script.js"></script>
	<script src="../../js/bootstrap.js"></script>
</head>
<body>

	<?php
		include('../header/navbar.php');
	?>

	<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Ajouter une machine</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form method="get" action="./enregistrementvehicule.php">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* Marque & Modèle</h5></td>
										</tr>
										<tr>
											<td>
												<select name="marque" required="required" class="form-control">
													<option selected disabled>Marque de la machine</option>
													<?php 
													$dbh = new db_functions();
													foreach ($dbh->getvehiculemarque() as $Valeur) {
													?>
														<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['libelle'];?></option>
													<?php
													}
													?>
												</select>
											</td>
											<td>
												<select name="modele" required="required" class="form-control">
													<option selected disabled>Modèle de la machine</option>
													<?php 
													$dbh = new db_functions();
													foreach ($dbh->getvehiculemodeles() as $Valeur) {
													?>
														<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['modele'];?></option>
													<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Genre & Catégorie</h5></td>
										</tr>
										<tr>
											<td>
												<select name="genre" required="required" class="form-control">
													<option selected disabled>Genre</option>
													<?php 
													$dbh = new db_functions();
													foreach ($dbh->getgenre() as $Valeur) {
													?>
														<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['genre'];?></option>
													<?php
													}
													?>
												</select>
											</td>
											<td>
												<select name="categorie" required="required" class="form-control">
													<option selected disabled>Catégorie</option>
													<?php 
													$dbh = new db_functions();
													foreach ($dbh->getcategorie() as $Valeur) {
													?>
														<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['categorie'];?></option>
													<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Energie & Equipements spéciaux</h5></td>
										</tr>
										<tr>
											<td>
												<select name="energie" required="required" class="form-control">
												<option selected disabled>Energie</option>
												<?php 
												$dbh = new db_functions();
												foreach ($dbh->getenergie() as $Valeur) {
												?>
													<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['energie'];?></option>
												<?php
												}
												?>
												</select>
											</td>
											<td>
												<select name="equipement" required="required" class="form-control">
												<option selected disabled>Equipements spéciaux</option>
												<?php 
												$dbh = new db_functions();
												foreach ($dbh->getequipement() as $Valeur) {
												?>
													<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['equipement'];?></option>
												<?php
												}
												?>
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Date d'enregistrement</h5></td>
											<td>
												<input data-format="yyyy-mm-dd" type="date" name="date" required="required" placeholder=" Date"/>
											</td>
										</tr>
										<tr>
											<td><h5>Matricule & Numéro de série</h5></td>
										</tr>
										<tr>
											<td>
												<input class="form-control" type="text" name="matricule" placeholder="Matricule"/>
											</td>
											<td>
												<input class="form-control" type="text" name="numerodeserie" placeholder="Numéro de série"/>
											</td>
										</tr>
										<tr>
											<td><h5>* Date d'achat</h5></td>
											<td>
												<input data-format="yyyy-mm-dd" type="date" name="dateachat" required="required" placeholder="Date d’achat">
											</td>
										</tr>
										<tr>
											<td><h5>* Date de mise en circulation</h5></td>
											<td>
												<input data-format="yyyy-mm-dd" type="date" name="misecirculation" required="required" placeholder="Date de mise en circulation">
											</td>
										</tr>
										<tr>
											<td><h5>* Kilométrage</h5></td>
											<td>
												<input class="form-control" type="text" name="kilometrage" required="required" placeholder="100 000"/>
											</td>
										</tr>
										<tr>
											<td><h5>Commentaires</h5></td>
											<td>
												<textarea class="form-control" rows="5" maxlength="140" name="commentaire" placeholder="Commentaires "></textarea>
											</td>
										</tr>
										<tr>
											
										</tr>
										<tr>
											<td><h5>* Lieu d'affectation</h5></td>
											<td>
												<select name="affectation" required="required" class="form-control">
												<option selected disabled>Affectation</option>
												<?php 
												$dbh = new db_functions();
												foreach ($dbh->getaffectation() as $Valeur) {
												?>
													<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['affectation'];?></option>	
												<?php
												}
												?>
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Etat</h5></td>
											<td>
												<select name="etat" required="required" class="form-control">
												<option selected disabled>Etat</option>
												<?php 
												$dbh = new db_functions();
												foreach ($dbh->getetat() as $Valeur) {
												?>
													<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['etat'];?></option>
												<?php
												}
												?>
												</select>
											</td>
										</tr>
										<tr>
											<td><input type="submit" class="btn btn-success" value="Enregistrer"/></td>
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
</body>
</html>