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
<img src="images/login.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
    <div class="container">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 templatemo-content-wrapper">
              <div class="templatemo-content">
                  <section id="menu-section" class="active">
                      <div class="row">
                          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                  <div class="black-bg btn-menu">
									<h2>Think Parc Software</h2>
									<form action="db/connect.php" method="POST">
										<div class="input-group input-sm">
											<span class="input-group-addon" id="basic-addon3">Identifiant</span>
											<input type="text" name="login" class="form-control" aria-describedby="basic-addon2" required>
										</div>
										<div class="input-group input-sm">
											<span class="input-group-addon" id="basic-addon3">Mot de passe</span>
											<input type="password" name="pass" class="form-control" aria-describedby="basic-addon2" required>
										</div>
										<button type="submit" class="btn btn-info btn-lg">Se connecter</button>
									</form>
                                  </div>
                          </div>
					</div>
				</section>
			</div>
		</div>
  </div>
</body>
</html>
