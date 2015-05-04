<?php
require('../../db/check_session.php');
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
	<script type="text/javascript" src="../../js/jquery.toast.js"></script>
</head>
<body>
	<?php include('../header/navbar.php'); ?>
	
	<img src="../../images/zoom-bg-5.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Mes informations</h2>
				<div class="panel-body">
				  <div class="row">
					<div class="col-md-3 col-lg-3 " align="center">
						<img alt="userpic" src="<?php echo "users_images/".$_SESSION['fct_image']; ?>" style="margin:10px;" class="img-circle imguser">
					</div>
					<div class=" col-md-9 col-lg-9 "> 
					  <table class="table table-user-information">
						<tbody>
						  <tr>
							<td><b>ID</b></td>
							<td class="infos"><?php echo $_SESSION['fct_id_user']; ?></td>
						  </tr>
						  <tr>
							<td><b>Firstname</b></td>
							<td><?php echo $_SESSION['fct_firstname']; ?></td>
						  </tr>
						  <tr>
							<td><b>Lastname</b></td>
							<td><?php echo $_SESSION['fct_lastname']; ?></td>
						  </tr>
						  <tr>
							<td><b>Login</b></td>
							<td><?php echo $_SESSION['fct_login']; ?></td>
						  </tr>
						  <tr>
							<td><b>Email</b></td>
							<td><?php echo $_SESSION['fct_email']; ?></td>
						  </tr>
						  <tr>
							<td><b>Mot de passe</b></td>
							<td>********</td>
						  </tr>
						  <tr>
							<td><b>Image</b></td>
							<td><?php echo $_SESSION['fct_image']; ?></td>
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
								<form class="formimg" action="javascript:updatePassword();" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="form-group col-xs-9" align="left">
											<input type="password" class="form-control" style="margin-bottom:3px;" id="oldpass" name="oldpass" placeholder="Mot de passe actuel" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" style="margin-bottom:3px;" id="newpass" name="newpass" placeholder="Nouveau mot de passe" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" id="confpass" name="confpass" placeholder="Confirmez votre nouveau mot de passe" aria-describedby="sizing-addon3">
										</div>
										<div class="form-group col-xs-3" align="right">
											<input type="submit" class="btn btn-default" name="submit" value="Valider">
											<script>
												function updatePassword() {
													var oldpass = document.getElementById("oldpass").value;
													var newpass = document.getElementById("newpass").value;
													sessionStorage.setItem("oldpass", oldpass);
													sessionStorage.setItem("newpass", newpass);
													$.ajax({
														type: 		"GET",
														url:		"http://www.think-parc.com/webservice/v1/companies/users/password/update",  
														success:	function(data) {
																		$(document).ready(function() {
																			$.toast({heading: "Success",text: "Password successfully updated.", icon: "success"});
																		});
																		document.getElementById()
																	},
														error:		function(xhr, status, error) {
																		$(document).ready(function() {
																			$.toast({heading: "Error",text: "Error", icon: "error"});
																		});
																	}
													});
													sessionStorage.removeItem("oldpass");
													sessionStorage.removeItem("newpass");
												}
											</script>
										</div>
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
							<form class="formimg" id="file-form" action="javascript:updateProfilePicture();" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="form-group col-xs-9" align="left">
										<span class="btn btn-default btn-file">
											Select a new profile picture...<input type="file" id="file-select" name="photo" />
										</span>
									</div>
									<div class="form-group col-xs-3" align="right">
										<input type="submit" id="upload-button" class="btn btn-default" name="submit" value="Upload">
										<script>
											function updateProfilePicture() {
												var form = document.getElementById('file-form');
												var fileSelect = document.getElementById('file-select');
												var files = fileSelect.files;
												var file = files[0];
												
												if (file == undefined) {
													$(document).ready(function() {
														$.toast({heading: "Error",text: "Please select a file.", icon: "error"});
													});
													return;
												}
												
												if (!file.type.match('image.*')) {
													$(document).ready(function() {
														$.toast({heading: "Error",text: "Only images are supported.", icon: "error"});
													});
													return;
												}												
												
												$(document).ready(function() {
													$.toast({heading: "Success",text: file.name + " uploaded.", icon: "success"});
												});
											}
										</script>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
			<?php
			if ($_SESSION['fct_id_role'] == 1) {
			?>
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Gestion des news</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">
							<div class="row">
								<form class="formimg" action="javascript:addNews(<?php echo $_SESSION['fct_id_user']; ?>);" method="post" enctype="multipart/form-data">
									<div class="form-group col-xs-9" align="left">
										<textarea id="newstext" name="newstext" class="form-control" rows="3" maxlength="140" placeholder="Publier une nouvelle"></textarea>
									</div>
									<div class="form-group col-xs-3" align="right">
										<input type="submit" class="btn btn-default" name="submit" value="Publier">
									</div>
								</form>
								<div id="post_actif_" class="form-group col-xs-12">
									<script>
										$(function onLoad(){
											getNews();
										});
										function getNews(){
											$.ajax({
												method: 	"GET",
												url:		"http://think-parc.com/webservice/v1/news/all",  
												success:	function(data) {
																var response = JSON.parse(data);
																var content = '<table class="table" style="width:100%;font-size:12px;">';
																for(var i = 0; i < response.length; i++) {
																	var news = response[i];
																	content += '<tr>';
																	content += '<td>' + news.date_news + '<td>';
																	content += '<td>' + news.msg + '<td>';
																	if (news.active==1) {
																		content += '<td><input id="' + news.id_news + '" name="post_actif_' + news.id_news + '" type="checkbox" onclick="updateNewsStatus(' + news.id_news + ', 0);" checked></td>';
																	} else {
																		content += '<td><input id="' + news.id_news + '" name="post_actif_' + news.id_news + '" type="checkbox" onclick="updateNewsStatus(' + news.id_news + ', 1);"></td>';
																	}
																	content += '<td><a href="javascript:deleteNews(' + news.id_news + ');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';
																	content += '</tr>';
																}
																content += '</table>';
																document.getElementById("post_actif_").innerHTML = content;
															}
											});
										};
										function updateNewsStatus(id, status) {
											$.ajax({
												type: 		"GET",
												url:		"http://www.think-parc.com/webservice/v1/news/" + id + "/status/" + status,  
												success:	function(data) {
																$(document).ready(function() {
																	$.toast({heading: "Success",text: "News successfully updated.", icon: "success"});
																});
																getNews();
															},
												error:		function(xhr, status, error) {
																$(document).ready(function() {
																	$.toast({heading: "Error",text: "Error", icon: "error"});
																});
															}
											});
										};
										function deleteNews(id) {
											$.ajax({
												type: 		"GET",
												url:		"http://www.think-parc.com/webservice/v1/news/" + id + "/delete",  
												success:	function(data) {
																$(document).ready(function() {
																	$.toast({heading: "Success",text: "News successfully removed.", icon: "success"});
																});
																getNews();
															},
												error:		function(xhr, status, error) {
																$(document).ready(function() {
																	$.toast({heading: "Error",text: "Error", icon: "error"});
																});
															}
											});
										};
										function addNews(id) {
											var newstext = document.getElementById("newstext").value;
											console.log("http://www.think-parc.com/webservice/v1/news/add/" + id + "/" + newstext);
											$.ajax({
												type: 		"GET",
												url:		"http://www.think-parc.com/webservice/v1/news/add/" + id + "/" + newstext,  
												success:	function(data) {
																$(document).ready(function() {
																	$.toast({heading: "Success",text: "News successfully added.", icon: "success"});
																});
																getNews();
															},
												error:		function(xhr, status, error) {
																$(document).ready(function() {
																	$.toast({heading: "Error",text: "Error", icon: "error"});
																});
															}
											});
											sessionStorage.removeItem("newstext");
										};
									</script>
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
