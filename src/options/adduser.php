<?php
 	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/options/adduser.fr.php');
	else
		include('../../lang/options/adduser.en.php');
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
      <script>
	  
	  	 $(function onLoad() 
			{
				getcompany();
				getroles();
				
			});
		
		function adduser(firstname, lastname, login, password, email, image, id_role, id_company) {
         									
			 var firstname  = document.getElementById("firstname").value;
			 var lastname  = document.getElementById("lastname").value;
			 var login  = document.getElementById("login").value;
			 var password  = document.getElementById("password").value;
			 var passconfirmation  = document.getElementById("passwordconfirmation").value;
			 var email  = document.getElementById("email").value;
			 var image  = document.getElementById("image").value;
			 var id_company  = document.getElementById("id_company").value;
			 var id_role  = document.getElementById("id_role").value;
			 
			 if (image == "")
			{
				image = "NULL";
			} else {
			
			var file = document.getElementById('image').files[0];
													var formData = new FormData();

													// Check the file type.
													var fakepath = document.getElementById("image").value;
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
													
														}
													xhr.send(formData);
					}
					
			if (password != passconfirmation) {
										$(document).ready(function() {
											$.toast({heading: "Error",text: "New password and confirmation are not identical.", icon: "error"});
												});
				
				} else if (!validateEmail(email))
					{
						$(document).ready(function() {
											$.toast({heading: "Error",text: "Please enter a valid email.", icon: "error"});
												});
				
				
				} else {
         $.ajax({
         									
         	type: 		"POST",
         	url:		"http://www.think-parc.com/webservice/v1/companies/options/adduser/"+firstname+"/lastname/"+lastname+"/login/"+login+"/password/"+password+"/email/"+email+"/image/"+ generatedfilename +"/id_role/"+id_role+"/id_company/"+id_company,  
         	success:	function(data) {
         	$(document).ready(function() {
         		$.toast({heading: "Success",text: "User successfully added.", icon: "success"});
         		});
         														
					},
         			error:		function(xhr, status, error) {
         			$(document).ready(function() {
         				$.toast({heading: "Error",text: "Error", icon: "error"});
         					});
         						}
         		});
				
					}
         											
         	};
			
			
			 function getcompany(){
				
				
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/options/getcompany",  
         		success:	function(data) {
         						var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $options['COMPANY'];?></option>';
         						for (var i = 0; i<response.length; i++) 
         						{
         						   content = content + '<option value="'+response[i].id_company+'">'+ response[i].name +'</option>';
         						}
         						document.getElementById("id_company").innerHTML = content;
							
         					}
					});
				 };
				 
				 function getroles(){
				
				
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/options/getroles",  
         		success:	function(data) {
         						var response = JSON.parse(data);
								var content = '<option selected disabled>Roles</option>';
         						for (var i = 0; i<response.length; i++) 
         						{
         						   content = content + '<option value="'+response[i].id_role+'">'+ response[i].role +'</option>';
         						}
         						document.getElementById("id_role").innerHTML = content;
							
         					}
					});
				 };
				 
			function validateEmail(email) {
				var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				return re.test(email);
			}
         											
      </script>
   </head>
   <body>

	<?php
		include('../header/navbar.php');
	?>

	<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=options">
						<h5><i class="fa fa-chevron-left"></i><?php echo $options['BACK'];?></h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $options['TITLE_ADDUSER'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form class="formimg" action="javascript:adduser(firstname, lastname, login, password, email, image, id_role, id_company);" method="post" enctype="multipart/form-data">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>*<?php echo $options['FIRSTNAMEANDLASTNAME'];?></h5></td>
										</tr>
										<tr>
											<td>
												 
												 <input type="text" id="lastname" placeholder="<?php echo $options['LASTNAME'];?>" class="form-control" required/>
											</td>
											<td>
												<input type="text" id="firstname" placeholder="<?php echo $options['FIRSTNAME'];?>" class="form-control" required/>
											</td>
										</tr>
										<tr>
											<td><h5>*<?php echo $options['LOGINANDEMAIL'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="login" placeholder="<?php echo $options['LOGIN'];?>" class="form-control" required/>
											</td>
											<td>
												<input type="text" id="email" placeholder="<?php echo $options['EMAIL'];?>" class="form-control" required/>
											</td>
										</tr>
										<tr>
											<td><h5>*<?php echo $options['PASSWORDTITLE'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="password" id="password" placeholder="<?php echo $options['PASSWORD'];?>" class="form-control" required/>
											</td>
											<td>
												<input type="password" id="passwordconfirmation" placeholder="<?php echo $options['CONFIRM_PASSWORD'];?>" class="form-control" required/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $options['COMPANYandROLE'];?></h5></td>
										</tr>
										<tr>
											<td>
												<select id="id_company" name="id_company" class="form-control">
													<!-- Here are loaded company content -->
												 </select>
											</td>
											<td>
												 <select id="id_role" name="id_role" class="form-control">
													<!-- Here are loaded role content -->
												 </select>
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $options['PICTURE'];?></h5></td>
										</tr>
										<tr>
										
											<td colspan="2">
												<h5><input class="form-group" type="file" id="image" name="myfiles"/></h5>
											</td>
										
										</tr>
									
										<tr>
											<td colspan="2" align="right">
												<input type="reset" value="<?php echo $options['RESET'];?>" class="btn btn-warning"/>
												<input type="submit" class="btn btn-success" value="<?php echo $options['SUBMIT'];?>"/>
											</td>
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
	<?php include('../footer/footer.php'); ?>
</body>
</html>