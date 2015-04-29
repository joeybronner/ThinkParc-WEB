<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
?>

<html>
<head>
	<meta charset="utf-8" />
	<title>Documents techniques véhicules</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/templatemo_main.css">
	<link rel="stylesheet" href="../../css/app.css">
	<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
	<script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery.backstretch.min.js"></script>
	<script src="../../js/templatemo_script.js"></script>
	<script src="../../js/bootstrap.js"></script>
	<script type="text/javascript" src="../../js/jquery.toast.js"></script>
</head>
<body>

	<?php
		include('../header/navbar.php');
	?>

	<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
	   <div class="templatemo-content">
		    <div class="margin-bottom-20">
				<center>
					<h1>Documents techniques vehicules</h1>
				</center>
			</div>
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Ajouter un document</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form class="formimg" action="ajouterdoctechnique.php" method="post" enctype="multipart/form-data">
								<div class="row">
									<table class="table-no-border">
										<tbody>
											<tr>
												<td>
													<select name="matricule" required="required" class="form-control">
													<option selected disabled>Immatriculation du véhicule</option>
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
												<td>
													<input class="form-control" required="required" type="text" name="nomfichier" placeholder="Nom du fichier"/>
												</td>
											</tr>
											<tr>
												<td>
													<span class="btn btn-default btn-file">
														Parcourir les fichiers... <input type="file" name="fileToUpload" id="fileToUpload">
													</span>
												</td>
												<td>
													<div class="form-group col-xs-12" align="right">
														<input type="submit" class="btn btn-success" name="submit" value="Ajouter">
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									
									<?php
										if (isset($_GET['add'])) {
											if ($_GET['add'] == "success") {
												echo '	<script>
															$(document).ready(function() {
																$.toast({heading: "Succès",text: "'. $_SESSION['fct_message'] .'", icon: "success"});}
															);
														</script>';
											} else {
												echo '	<script>
															$(document).ready(function() {
																$.toast({heading: "Erreur",text: "'. $_SESSION['fct_message'] .'", icon: "error"});}
															);
														</script>';
											}
										}
									?>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Consultation / Téléchargement</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>