<?php
   session_start();
?>
<html>
	<head>
		<title>Véhicules et conducteurs</title>
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
		<meta name="description" content="">
		<meta charset="utf-8">
		<link rel="stylesheet" href="../../css/bootstrap.css">
		<link rel="stylesheet" href="../../css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">
		<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
		<link rel="stylesheet" href="../../css/DataTable/jquery.dataTables_themeroller.css">
	    <link rel="stylesheet" href="../../css/DataTable/jquery.dataTables.min.css">
	    <link rel="stylesheet" href="../../css/DataTable/jquery.dataTables.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/jquery.backstretch.min.js"></script>
		<script src="../../js/templatemo_script.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script src="../../js/jquery.toast.js"></script>
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/jquery.dataTables.js"></script>	  
	    <script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	
		<script type="text/javascript">
			$(function onLoad() {
				document.getElementById("vehiclesanddriversdetail").style.display = "none";
				getAllVehicles();
			});
			function getAllVehicles(){
				getCompany(function(company){
					$.ajax({
						method: 	"GET",
						url:		"http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all",  
						success:	function(data) {
										var response = JSON.parse(data);
										var content = '<option selected disabled>Liste des véhicules</option>';
										for (var i = 0; i<response.length; i++) {
											content = content + '<option value="' + response[i].id_vehicle + '">' + response[i].nr_plate + '</option>';
										}
										document.getElementById("listvehicles").innerHTML = content;
									}
					});
				});
			};
			function getCompany(handleData){
				var id_user = <?php echo $_SESSION['fct_id_user']; ?>;
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/users/" + id_user,  
					success:	function(data) {
									var response = JSON.parse(data);
									handleData(response[0].id_company);
								}
				});
			};
			function displayVehicle(id) {
				getCompany(function(company){
					var dataSet = [
						['Joey Bronner', '45673638848484', '2015-01-01', '2015-02-15']
					];
					
					$('#drivers').html( '<table class="display" id="example"></table>' );
							
					$('#example').dataTable( {
						"data": dataSet,
						   "bPaginate": true,
						   "bLengthChange": true,
						   "bStateSave": true,
						   "bFilter": true,
						   "bSort": true,
						   "bInfo": true,
						   "bAutoWidth": true,
						"columns": [
							{ "title": "driver" , "class": "center" },
							{ "title": "driving licence" , "class": "center"},
							{ "title": "start" , "class": "center" },
							{ "title": "end", "class": "center" }
						]
					} );

					document.getElementById("vehiclesanddriversdetail").style.display = "block";					
				
				});
			}
		</script>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Détails administratifs de vos véhicules</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<table class="table-no-border">
										<tr>
											<td><h5>Veuillez sélectionner un véhicule dans la liste</h5></td>
										</tr>
										<tr>
											<td>
												<select id="listvehicles" name="listvehicles" class="form-control" onchange="displayVehicle(this.value);">
													<!-- Retrieve all vehicles with an AJAX [GET] query -->
												</select>
											</td>
										</tr>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div id="vehiclesanddriversdetail" class="black-bg btn-menu margin-bottom-20">
					<h2>Documents administratifs concernant ce véhicule</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12"><table class="table table-user-information">
										<table id="vehicledetail" class="table-no-border">
											<tbody>
												<tr>
													<td>Historique des conducteurs de ce véhicule</td>
												</tr>
												<tr>
													<td id="drivers">
														
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:alert('show fields');"><i id="insur_choice" class="fa fa fa-plus-circle"></i></a>
														Ajouter un conducteur
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   </body>
</html>