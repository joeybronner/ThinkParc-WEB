<?php
	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/infos/infos.fr.php');
	else
		include('../../lang/infos/infos.en.php');
?>
<html>
<head>
	<title>Think-Parc | My documents</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/templatemo_main.css">
	<link rel="stylesheet" href="../../css/app.css">
	<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
	<script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery-ui.min.js"></script>
    <script src="../../js/jquery.backstretch.min.js"></script>
    <script src="../../js/templatemo_script.js"></script>
	<script src="../../js/bootstrap.js"></script>
	<script src="../../js/jquery.toast.js"></script>
	<script>
	$(function onLoad(){
		// On load
	});
	</script>
</head>
<body>
	<?php include('../header/navbar.php'); ?>
	<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad" >
		<div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Documents</h2>
				<div class="panel-body">
					<!--Content-->
				</div>
			</div>
		</div>
	</div>
	<?php include('../footer/footer.php'); ?>
</body>
</html>
