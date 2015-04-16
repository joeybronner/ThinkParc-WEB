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
	<link rel="stylesheet" href="../../css/formul_files/formoid1/formoid-flat-green.css" type="text/css" />
	<script type="text/javascript" src="../../js/jquery.js"></script>
	  <script type="text/javascript">
	  $(document).ready(function() {  
		$('#example').dataTable( {
		  "bPaginate": false,
		  "bLengthChange": false,
		  "bStateSave": true,
		  "bFilter": false,
		  "bSort": false,
		  "bInfo": false,
		  "bAutoWidth": false
		} );
	  } );
	  </script>
	<script type="text/javascript">
	sfHover = function() {
		var sfEls = document.getElementById("nav").getElementsByTagName("li");
		for (var i=0; i<sfEls.length; i++) {
		  sfEls[i].onmouseover=function() {
		   this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
		  this.className=this.className.replace(new RegExp(" sfhover\b"), "");
		}
	  }
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);
	</script>
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
	
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
        <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Mes informations</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center">
					<img alt="userpic" src="<?php echo "users_images/" . $image; ?>" class="img-circle imguser">
				</div>
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
					  <tr>
                        <td><b>ID</b></td>
                        <td><?php echo $id; ?></td>
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
		
		<div class="panel panel-info">
            <div class="panel-heading">
				<h3 class="panel-title">Modifier mon mot de passe</h3>
            </div>
            <div class="panel-body">
				<div class="row">
					<div class="col-md-12 col-lg-12" align="center">		
						<div class="input-group input-group-sm">
							<form class="formimg" action="modifiermdp.php" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="form-group col-xs-9" align="left">
										<input type="password" class="form-control" name="ancienmdp" placeholder="Ancien mot de passe" aria-describedby="sizing-addon3">
										<input type="password" class="form-control" name="nouveaumdp" placeholder="Nouveau mot de passe" aria-describedby="sizing-addon3">
										<input type="password" class="form-control" name="confirmationmdp" placeholder="Confirmez votre nouveau mot de passe" aria-describedby="sizing-addon3">
									</div>
									<div class="form-group col-xs-3" align="right">
										<input type="submit" class="btn btn-default" name="submit" value="Valider">
									</div>
									<?php
									if (isset($_GET['pass'])) {
										if ($_GET['pass'] == "success") {
											echo '<div style="color:#009933;">' . $_SESSION['fct_message'] . '</div>';
										} else {
											echo '<div style="color:#CC0000;">' . $_SESSION['fct_message'] . '</div>';
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
	
		<div class="panel panel-info">
            <div class="panel-heading">
				<h3 class="panel-title">Modifier mon image</h3>
            </div>
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
											echo '<div style="color:#009933;">' . $_SESSION['fct_message'] . '</div>';
										} else {
											echo '<div style="color:#CC0000;">' . $_SESSION['fct_message'] . '</div>';
										}
									}
								?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
</body>
</html>
