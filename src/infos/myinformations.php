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
	<title><?php echo $infos['TITLE_MYINFORMATIONS'];?></title>
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
	<script>
	$(function onLoad(){
		getUserInfos();
		getNews();
	});
	function getUserInfos() {
		var id_user = document.getElementById("id_user").innerText;
		$.ajax({
			type: 		"GET",
			url:		"http://www.think-parc.com/webservice/v1/companies/users/" + id_user,  
			success:	function(data) {
							var response = JSON.parse(data);
							document.getElementById("firstname").innerText = response[0].firstname;
							document.getElementById("lastname").innerText = response[0].lastname;
							document.getElementById("login").innerText = response[0].login;
							document.getElementById("email").innerText = response[0].email;
							document.getElementById("image").innerText = response[0].image;
							document.getElementById("userpic").src = "../../files/img_users/" + response[0].image;
						}
		});
	};
	</script>
</head>
<body>
	<?php include('../header/navbar.php'); ?>
	
	<img src="../../images/background/home/think_parc_home_1.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $infos['MYINFORMATIONS'];?></h2>
				<div class="panel-body">
				  <div class="row">
					<div class="col-md-3 col-lg-3 " align="center">
						<img alt="userpic" id="userpic" style="margin:10px;" class="img-circle imguser">
					</div>
					<div class=" col-md-9 col-lg-9 "> 
					  <table class="table table-user-information">
						<tbody>
						  <tr>
							<td class="info_title">ID</td>
							<td id="id_user"><?php echo $_SESSION['fct_id_user']; ?></td>
						  </tr>
						  <tr>
							<td class="info_title"><?php echo $infos['FIRSTNAME'];?></td>
							<td id="firstname"></td>
						  </tr>
						  <tr>
							<td class="info_title"><?php echo $infos['LASTNAME'];?></td>
							<td id="lastname"></td>
						  </tr>
						  <tr>
							<td class="info_title"><?php echo $infos['LOGIN'];?></td>
							<td id="login"></td>
						  </tr>
						  <tr>
							<td class="info_title"><?php echo $infos['EMAIL'];?></td>
							<td id="email"></td>
						  </tr>
						  <tr>
							<td class="info_title"><?php echo $infos['PASSWORD'];?></td>
							<td>********</td>
						  </tr>
						  <tr>
							<td class="info_title"><?php echo $infos['PROFILEPICTURE'];?></td>
							<td id="image"></td>
						  </tr>
						</tbody>
					  </table>
					</div>
				  </div>
				</div>
			</div>
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $infos['CHANGE_PASSWORD'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">		
							<div class="input-group input-group-sm">
								<form id="formpassword" class="formimg" action="javascript:updatePassword(<?php echo $_SESSION['fct_id_user']; ?>);" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="form-group col-xs-9" align="left">
											<input type="password" class="form-control" style="margin-bottom:3px;" id="oldpass" name="oldpass" placeholder="<?php echo $infos['OLD_PASSWORD'];?>" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" style="margin-bottom:3px;" id="newpass" name="newpass" placeholder="<?php echo $infos['NEW_PASSWORD'];?>" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" id="confpass" name="confpass" placeholder="<?php echo $infos['CONFIRM_PASSWORD'];?>" aria-describedby="sizing-addon3">
										</div>
										<div class="form-group col-xs-3" align="right">
											<input type="submit" class="btn btn-success" name="submit" value="<?php echo $infos['SUBMIT'];?>">
											<script>
												function updatePassword(id) {
													// Check if all fields are completed
													var oldpass = document.getElementById("oldpass").value;
													var newpass = document.getElementById("newpass").value;
													var confpass = document.getElementById("confpass").value;
													if (oldpass==="" || newpass==="" || confpass==="") {
														$(document).ready(function() {
															$.toast({heading: "Error",text: "All fields are required to change your password.", icon: "error"});
														});
													} else if (newpass != confpass) {
														$(document).ready(function() {
															$.toast({heading: "Error",text: "New password and confirmation are not identical.", icon: "error"});
														});
													} else {
														// Check old password
														$.ajax({
															type: 		"GET",
															url:		"http://www.think-parc.com/webservice/v1/companies/users/" + id,  
															success:	function(data) {
																			var response = JSON.parse(data);
																			if (response[0].pass === oldpass) {
																				// Update new password
																				$.ajax({
																					type: 		"GET",
																					url:		"http://www.think-parc.com/webservice/v1/companies/users/password/update/" + id + "/" + newpass,  
																					success:	function(data) {
																									$(document).ready(function() {
																										document.getElementById("formpassword").reset();
																										$.toast({heading: "Success",text: "Password successfully updated.", icon: "success"});
																									});
																								},
																					error:		function(xhr, status, error) {
																									$(document).ready(function() {
																										$.toast({heading: "Error",text: "Error", icon: "error"});
																									});
																								}
																				});
																			} else {
																				$(document).ready(function() {
																					$.toast({heading: "Error",text: "Your old password is not correct.", icon: "error"});
																				});
																			}
																		}
														});
													}
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
				<h2><?php echo $infos['CHANGE_PROFILEPICTURE'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">		
							<form id="file-form" action="javascript:uploadFile(<?php echo $_SESSION['fct_id_user']; ?>);" method="POST">
									<table>
										<tr>
											<td>
												<h5><input class="form-group" type="file" id="file-select" name="myfiles"/></h5>
											</td>
											<td align="right">
												<button type="submit" id="upload-button" class="btn btn-success"><?php echo $infos['UPLOAD'];?></button>
												<script>
												function uploadFile(id_user) {
													var file = document.getElementById('file-select').files[0];
													var formData = new FormData();

													// Check the file type.
													var fakepath = document.getElementById("file-select").value;
													var ext = "." + fakepath.substr(fakepath.lastIndexOf('.') + 1);
													if (!file.type.match('image.*')) {
															$(document).ready(function() {
																$.toast({heading: "Error",text: "Only pictures are supported.", icon: "error"});
															});
													} else {
														// Add file to data form
														var d = new Date();
														var generatedfilename = d.getTime() + "_" + file.name;
														formData.append('myfiles', file, generatedfilename);
														var xhr = new XMLHttpRequest();
														xhr.open('POST', '../../files/uploadfile.php?target=img_users', true);
														xhr.onload = function () {
															if (xhr.readyState == 4) {
																if (xhr.status == 200) {
																	$(document).ready(function() {
																		$.ajax({
																			method: 	"PUT",
																			url:		"http://think-parc.com/webservice/v1/companies/users/" + id_user + "/profilepicture/" + generatedfilename + ext,
																			success:	function(data) {
																								$(document).ready(function() {
																									$('#file-form').each(function(){
																										this.reset();
																									});
																									getUserInfos();
																									$.toast({heading: "Success",text: "Picture successfully uploaded.", icon: "success"});
																								});	
																							},
																			error:		function(xhr, status, error) {
																								$(document).ready(function() {
																									$.toast({heading: "Error",text: "", icon: "error"});
																								});
																							}
																		});
																	});		
																} else {
																	$(document).ready(function() {
																		$.toast({heading: "Error",text: "", icon: "error"});
																	});
																}	
															} 
														};
														xhr.send(formData);
													}
												}
												</script>
											</td>
										</tr>
									</table>
							</form>
						</div>
					</div>
				</div>
			</div>
			
			<?php
			if ($_SESSION['fct_id_role'] == 1) {
			?>
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $infos['NEWS_MANAGEMENT'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">
							<div class="row">
								<form class="formimg" action="javascript:addNews(<?php echo $_SESSION['fct_id_user']; ?>);" method="post" enctype="multipart/form-data">
									<div class="form-group col-xs-9" align="left">
										<textarea id="newstext" name="newstext" class="form-control" rows="3" maxlength="140" placeholder="<?php echo $infos['PUBLISH_NEWS'];?>"></textarea>
									</div>
									<div class="form-group col-xs-3" align="right">
										<input type="submit" class="btn btn-success" name="submit" value="Publier">
									</div>
								</form>
								<div id="post_actif_" class="form-group col-xs-12">
									<script>
										function reformatDate(dateStr) {
										  dArr = dateStr.split("-");
										  return dArr[2]+ "/" +dArr[1]+ "/" +dArr[0];
										}
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
																	content += '<td>' + reformatDate(news.date_news) + '<td>';
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
<?php include('../footer/footer.php'); ?>
</body>
</html>
