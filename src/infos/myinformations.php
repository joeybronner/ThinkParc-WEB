<?php
require_once('../../db/config.php'); 
include('../../db/db_functions.php');
session_start();
$dbh = new db_functions();
?>

<html>
<head>
	<title>FCT</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/templatemo_main.css">
	<link rel="stylesheet" href="../../css/app.css">
	<script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery-ui.min.js"></script>
    <script src="../../js/jquery.backstretch.min.js"></script>
    <script src="../../js/templatemo_script.js"></script>
	<script src="../../js/bootstrap.js"></script>
</head>
<body>
	<?php include('../header/navbar.php'); ?>
	<?php
		$dbh->getinfouser();			
		foreach ($dbh->getinfouser() as $Valeur) {
			$id = $Valeur['id'];
			$nom = $Valeur['nom'];
			$prenom = $Valeur['prenom'];
			$login = $Valeur['login'];
			$image = $Valeur['image'];
			$email = $Valeur['email'];
		}	
	?>
	
	<img src="../../images/zoom-bg-5.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Mes informations</h2>
				<div class="panel-body">
				  <div class="row">
					<div class="col-md-3 col-lg-3 " align="center">
						<img alt="userpic" src="<?php echo "users_images/" . $image; ?>" style="margin:10px;" class="img-circle imguser">
					</div>
					<div class=" col-md-9 col-lg-9 "> 
					  <table class="table table-user-information">
						<tbody>
						  <tr>
							<td><b>ID</b></td>
							<td class="infos"><?php echo $id; ?></td>
						  </tr>
						  <tr>
							<td><b>Nom</b></td>
							<td><?php echo $nom; ?></td>
						  </tr>
						  <tr>
							<td><b>Prenom</b></td>
							<td><?php echo $prenom; ?></td>
						  </tr>
						  <tr>
							<td><b>Login</b></td>
							<td><?php echo $login; ?></td>
						  </tr>
						  <tr>
							<td><b>Email</b></td>
							<td><?php echo $email; ?></td>
						  </tr>
						  <tr>
							<td><b>Mot de passe</b></td>
							<td>********</td>
						  </tr>
						  <tr>
							<td><b>Image</b></td>
							<td><?php echo $image; ?></td>
						  </tr>
						</tbody>
					  </table>
					</div>
				  </div>
				</div>
			</div>
			
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Modifier mon mot de passe</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">		
							<div class="input-group input-group-sm">
								<form class="formimg" action="modifiermdp.php" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="form-group col-xs-9" align="left">
											<input type="password" class="form-control" style="margin-bottom:3px;" name="ancienmdp" placeholder="Ancien mot de passe" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" style="margin-bottom:3px;" name="nouveaumdp" placeholder="Nouveau mot de passe" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" name="confirmationmdp" placeholder="Confirmez votre nouveau mot de passe" aria-describedby="sizing-addon3">
										</div>
										<div class="form-group col-xs-3" align="right">
											<input type="submit" class="btn btn-default" name="submit" value="Valider">
										</div>
										<?php
										if (isset($_GET['pass'])) {
											if ($_GET['pass'] == "success") {
												echo '<div style="color:#009933;"><h5>' . $_SESSION['fct_message'] . '</h5></div>';
											} else {
												echo '<div style="color:#CC0000;"><h5>' . $_SESSION['fct_message'] . '</h5></div>';
											}
										}
										?>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Modifier mon image</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">		
							<form class="formimg" action="ajouterimage.php" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="form-group col-xs-9" align="left">
										<span class="btn btn-default btn-file">
											Parcourir les fichiers... <input type="file" name="fileToUpload" id="fileToUpload">
										</span>
									</div>
									<div class="form-group col-xs-3" align="right">
										<input type="submit" class="btn btn-default" name="submit" value="Valider">
									</div>
									<?php
										if (isset($_GET['add'])) {
											if ($_GET['add'] == "success") {
												echo '<div style="color:#009933;"><h5>' . $_SESSION['fct_message'] . '</h5></div>';
											} else {
												echo '<div style="color:#CC0000;"><h5>' . $_SESSION['fct_message'] . '</h5></div>';
											}
										}
									?>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
