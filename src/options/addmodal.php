<?php
   session_start();

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
				getBrand();
				document.getElementById("modal").style.display = "none";
				
			});	
	
		
		function addModal() {
         									
			 var modal = document.getElementById("modal").value;
					
         									
         $.ajax({
         									
         	type: 		"POST",
         	url:		"http://www.think-parc.com/webservice/v1/companies/options/addModal/"+modal+"/idbrand/"+id_brand,  
         	success:	function(data) {
         	$(document).ready(function() {
         		$.toast({heading: "Success",text: "Brand successfully added.", icon: "success"});
         		});
         														
					},
         			error:		function(xhr, status, error) {
         			$(document).ready(function() {
         				$.toast({heading: "Error",text: "Error", icon: "error"});
         					});
         						}
         		});
         											
         	};
         	

				 function getBrand(){
				
				
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/options/allbrands",  
         		success:	function(data) {
         						var response = JSON.parse(data);
								var content = '<option selected disabled>Marque</option>';
         						for (var i = 0; i<response.length; i++) 
         						{
         						   content = content + '<option value="'+response[i].id_brand+'">'+ response[i].brand +'</option>';
         						}
         						document.getElementById("brand").innerHTML = content;
							
         					}
					});
				 };
			
			
			
			 function displayinput(){
				
				document.getElementById("modal").style.display = "block";
         
			};
    	
	
         								
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
						<h5><i class="fa fa-chevron-left"></i> Retour</h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2>Ajouter un modèle</h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form class="formimg" action="javascript:addModal();" method="post" enctype="multipart/form-data">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* Marque</h5></td>
										</tr>
										<tr>
											<td>
												 <select id="brand" name="brand" class="form-control" Onchange="displayinput();">
													<!-- Here are loaded Brand content -->
												 </select>
											</td>
										</tr>
												<tr>
											<td>
												<input type="text" id="modal" placeholder="modèle" class="form-control" required/>
											</td>
										</tr>
										
										<tr>
											<td colspan="3" align="right">
												<input type="reset" value="Reinitialiser" class="btn btn-warning"/>
												<input type="submit" class="btn btn-success" value="Enregistrer"/>
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
</body>
</html>