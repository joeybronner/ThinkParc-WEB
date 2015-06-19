<?php
       	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/stocks/addinstock.fr.php');
	else
		include('../../lang/stocks/addinstock.en.php');
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
		var idpart = "";
				
	  
	   function checkref(ref){
				
				var div = document.getElementById("textDiv");
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				ref = document.form1.ref.value;
				
					if (ref == "")
					 {
						div.textContent = "";
			     	 }
								
				
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/checkref/"+ref+"/company/"+id_company,  
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var verif = false;
						        
         						for (var i = 0; i<response.length; i++) 
         						{
									if (ref.toUpperCase() == response[i].reference.toUpperCase())
										{
											verif=true;
											idpart = response[i].id_part;
										}
         						}
   							
								if (verif)
								{
									div.textContent = "  <?php echo $stocks['EXIST'];?>";
									div.className='green';
								} else {
									div.className='red';
									div.textContent = "  <?php echo $stocks['NOTEXIST'];?>";
									idpart = "";
								}
							
							}
			});
         };
	  

        $(function getSites(id_company){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/sites", 
         		success:	function(data) {
         						var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['SITE'];?></option>';
         					
         						for (var i = 0; i<response.length; i++) 
         						{
									 content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						document.getElementById("SitesContent").innerHTML = content;
         					}
         	});
         });
         	
         $(function getKinds(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/kinds",  
         		success:	function(data) {
         						var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['KINDS'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									 content = content + '<option value="'+response[i].id_kind+'">'+ response[i].kind +'</option>';
         						}
         						document.getElementById("KindsContent").innerHTML = content;
         					}
         	});
         });
         
         		$(function getMeasurement(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/measurements",  
         		success:	function(data) {
         						var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['MEASURE'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_measurement+'">'+ response[i].measurement +'</option>';
         						}
								
         						document.getElementById("measurementContent").innerHTML = content;
         					}
         	});
         });
         	
         	
			function addinstock() {
         									
         									
         	var quanty = document.getElementById("quanty").value;
			var driveway = document.getElementById("driveway").value;
         	var bay = document.getElementById("bay").value;
			var position = document.getElementById("position").value;
         	var rack = document.getElementById("rack").value;
         	var locker = document.getElementById("locker").value;
         	var id_typestock = document.getElementById("KindsContent").value;
         	var id_site = document.getElementById("SitesContent").value;
         	var id_measurement = document.getElementById("measurementContent").value;
         									
         		$.ajax({
         									
         			type: 		"POST",
         			url:		"http://www.think-parc.com/webservice/v1/companies/stocks/addinstock/quanty/"+quanty+"/id_measurement/"+id_measurement+"/driveway/"+driveway+"/bay/"+bay+"/position/"+position+"/locker/"+locker+"/rack/"+rack+"/id_site/"+id_site+"/id_typestock/"+id_typestock+"/id_part/"+window.idpart,  
         			success:	function(data) {
         					$(document).ready(function() {
         						$.toast({heading: "Success",text: "Product successfully added.", icon: "success"});
         						});
         														
         							},
         					error:		function(xhr, status, error) {
         						$(document).ready(function() {
									$.toast({heading: "Error",text: "Error", icon: "error"});
         													});
																	}
         				});
         											
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
				<a href="../accueil.php?section=products">
						<h5><i class="fa fa-chevron-left"></i><?php echo $stocks['BACK'];?></h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $stocks['TITLE'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form class="formimg" name="form1" action="javascript:addinstock();" method="post" enctype="multipart/form-data">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* <?php echo $stocks['REFERENCE'];?></h5></td>
										</tr>
										<tr>
											<td>
												 <script>
													var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
												 </script>
												 <input type="text" id="ref" placeholder="<?php echo $stocks['REFERENCE'];?>" onkeyup="checkref(ref, id_company);" class="form-control" required/> 
											</td>
											<td>
												<div id="textDiv"  class="red"/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['QUANTITYANDMEASURE'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="quanty" class="form-control" placeholder="<?php echo $stocks['QUANTITY'];?>" required/>
											</td>
											<td>
												<select id="measurementContent" class="form-control">
                                             <!-- Here are loaded measurementContent  -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['LOCATION'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="id_measurement" class="form-control" placeholder="<?php echo $stocks['MAGASIN'];?>" required/>
											</td>
											<td>
												<input type="text" id="driveway" class="form-control" placeholder="<?php echo $stocks['DRIVE'];?>" required/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['LOCATION'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="bay" class="form-control" placeholder="<?php echo $stocks['BAY'];?>" required/>
											</td>
											<td>
												<input type="text" id="rack" class="form-control" placeholder="<?php echo $stocks['RACK'];?>" required/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['LOCATION'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="locker" class="form-control" placeholder="<?php echo $stocks['LOCKER'];?>" required/>
											</td>
											<td>
												<input type="text" id="position" class="form-control" placeholder="<?php echo $stocks['POSITION'];?>" required/>
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $stocks['LOCATIONANDTYPE'];?></h5></td>
										</tr>
										<tr>
											<td>
											    <input type="text" id="equivalence" class="form-control" placeholder="<?php echo $stocks['OPTIONAL'];?>"/>
											</td>
											<td>
												<select id="KindsContent" class="form-control" required/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['ASSIGNMENT'];?></h5></td>
										</tr>
										<tr>
											<td>
												<select id="SitesContent" class="form-control" required/>
											</td>
										
										</tr>
										
										<tr>
											<td colspan="2" align="right">
												<input type="reset" value="<?php echo $stocks['RESET'];?>" class="btn btn-warning"/>
												<input type="submit" class="btn btn-success" value="<?php echo $stocks['SUBMIT'];?>"/>
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