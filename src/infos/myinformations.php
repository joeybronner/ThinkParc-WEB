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
	<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery-ui.min.js"></script>
    <script src="../../js/jquery.backstretch.min.js"></script>
    <script src="../../js/templatemo_script.js"></script>
	<script src="../../js/bootstrap.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
	<script>
	$(document).on('change', 'input:checkbox[name^="post_actif_"]', function (event) {
		var currentId = $(this).attr('id');
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					$.toast({
						heading: 'News',
						text: 'Modification effectuée.',
						icon: 'info'
					})
			}
		}
		xmlhttp.open("UPDATE","updatenews.php?id="+currentId,true);
		xmlhttp.send();
	});
	</script>
	<script type="text/javascript" src="../../js/jquery.toast.js"></script>
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
		$privilege = $_SESSION['fct_privilege'];
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
											<input type="password" class="form-control" style="margin-bottom:3px;" id="ancienmdp" name="ancienmdp" placeholder="Mot de passe actuel" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" style="margin-bottom:3px;" id="nouveaumdp" name="nouveaumdp" placeholder="Nouveau mot de passe" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" id="confirmationmdp" name="confirmationmdp" placeholder="Confirmez votre nouveau mot de passe" aria-describedby="sizing-addon3">
										</div>
										<div class="form-group col-xs-3" align="right">
											<input type="submit" class="btn btn-default" name="submit" value="Valider">
										</div>
										<?php
										if (isset($_GET['pass'])) {
											if ($_GET['pass'] == "success") {
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
			
			<?php
			if ($privilege == "admin") {
			?>
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Gestion des news</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">
							<div class="row">
								<form class="formimg" action="ajouternews.php" method="post" enctype="multipart/form-data">
									<div class="form-group col-xs-9" align="left">
										<textarea id="newstext" name="newstext" class="form-control" rows="3" maxlength="140" placeholder="Publier une nouvelle"></textarea>
									</div>
									<div class="form-group col-xs-3" align="right">
										<input type="submit" class="btn btn-default" name="submit" value="Publier">
									</div>
								</form>
								<div id="post_actif_" class="form-group col-xs-12">
										<table class="table" style="width:100%;font-size:12px;">
												<?php	
													foreach ($dbh->getAllNews() as $news) {
														$id = $news['id'];
														$date = $news['date'];
														$auteur = $news['auteur'];
														$msg = $news['msg'];
														$actif = $news['actif'];
														
														echo '<tr>';
														echo '<td>'.$date.'<td>';
														echo '<td>'.$msg.'<td>';
														if ($actif==1) {
															echo '<td><input id="'.$id.'" name="post_actif_'.$id.'" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-size="mini" checked></td>';
														} else {
															echo '<td><input id="'.$id.'" name="post_actif_'.$id.'" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-size="mini"></td>';
														}
														echo '<td><a href="deletenews.php?id='.$id.'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';
														echo '</tr>';
													}
												?>
										</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>
</body>
</html>
