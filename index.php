<?php
	require('db/check_session_index.php');
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Think Parc Software</title>
	<meta name="" content="width=device-width">	
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/templatemo_main.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.backstretch.min.js"></script>
	<script src="js/templatemo_script.js"></script>
	<script src="js/bootstrap.js"></script>
</head>
<body>
	<img src="images/background/home/think_parc_home_4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
    <div class="container" style="margin-top:30px;">
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xs-offset-0 col-sm-offset-0 col-md-offset-4 col-lg-offset-4">
            <div class="templatemo-content">
                <section id="menu-section" class="active">
                    <div class="row">
						<div class="black-bg btn-menu" style="padding:30px;">
							<h2>Think Parc Software</h2>
							<form action="db/connect.php" method="POST">
								<div class="input-group input-sm">
									<span class="input-group-addon">Identifiant</span>
									<input type="text" name="login" class="form-control" required>
								</div>
								<div class="input-group input-sm">
									<span class="input-group-addon">Mot de passe</span>
									<input type="password" name="pass" class="form-control" required>
								</div>
								<button type="submit" class="btn btn-info btn-lg">Se connecter</button>
							</form>
						</div>
					</div>
				</section>
			</div>
		</div>
  </div>
</body>
</html>
