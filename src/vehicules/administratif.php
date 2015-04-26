<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Formulaire administratif</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/templatemo_main.css">
	<link rel="stylesheet" href="../../css/app.css">
</head>

<body style="background-color:#a6a6a6">

	<?php
		include('../header/navbar.php');
	?>
	
	<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Formulaire administratif</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form method="get" action="ajoutadministratif.php">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* Matricule de la machine</h5></td>
											<td>
												<select name="matricule" required="required" class="form-control">
													<option selected disabled>Matricule de la machine</option>
													<?php 
													$dbh = new db_functions();
													foreach ($dbh->getimmatriculation() as $Valeur) {
													?>	
														<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['matricule'];?></option>
													<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* Date du dernier contrôle technique</h5></td>
											<td>
												<input data-format="yyyy-mm-dd" type="date" name="derniercontrole" required="required"/>
											</td>
										</tr>
										<tr>
											<td><h5>* Date du prochain contrôle technique</h5></td>
											<td>
												<input data-format="yyyy-mm-dd" type="date" name="prochaincontrole" required="required"/>
											</td>
										</tr>
										<tr>
											<td><h5>* Assureur & Fournisseur</h5></td>
										</tr>
										<tr>
											<td>
												<select name="assurance" required="required" class="form-control">
													<option selected disabled>Assureur</option>
													<?php 
													$dbh = new db_functions();
													foreach ($dbh->getassurance() as $Valeur) {
													?>
														<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['nomassurance'];?></option>
													<?php
													}
													?>
												</select>
											</td>
											<td>
												<select name="fournisseur" required="required" class="form-control">
													<option selected disabled>Fournisseur</option>
													<?php 
													$dbh = new db_functions();
													foreach ($dbh->getfournisseur() as $Valeur) {
													?>
														<option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['fournisseur'];?></option>
													<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>N° d'assurance & Prix d'achat</h5></td>
										</tr>
										<tr>
											<td>
												<input class="form-control" type="text" name="numcontratassurance" placeholder="N° du contrat d'assurance"/>
											</td>
											<td>
												<input class="form-control" type="text" name="prixachat" placeholder="Prix d'achat"/>
											</td>
										</tr>
										<tr>
											<td><h5>Echéance assurance</h5></td>
											<td>
												<input data-format="yyyy-mm-dd" type="date" name="echeanceassurance" />
											</td>
										</tr>
										<tr>
											<td><h5>Conducteurs</h5></td>
											<td>
												<textarea class="form-control" rows="5" maxlength="140" name="conducteur" placeholder="Prénom NOM du ou des conducteur(s) séparés par une virgule"></textarea>
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
