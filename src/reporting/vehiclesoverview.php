<?php
/* ======================================================================== *
 *																			*
 * @filename:		vehiclesoverview.php									*
 * @description:	Reporting for a specific vehicle between a 				*
 * 					range of date											*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @creation: 		01/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 01/06/2015 | J.BRONNER      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/
 ?>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php
		if(!isset($_SESSION)) {
			session_start();
		}
		
		/* 1. Import contants values with DIR path used for future imports */
		require('../header/constants.php');
		
		/* 2. Check session's state and authentication */
		require(BASE_PATH . '/db/check_session.php');
		
		/* 3. Include CSS (design) & JS (features) files */
		require(BASE_PATH . '/src/header/cssandjsfiles.php');
		
		/* 4. Import language values: French or English files */
		/*if($_SESSION['fct_lang'] == 'FR') {
			include('../../lang/maintenance/maintenance.fr.php');
		} else {
			include('../../lang/maintenance/maintenance.en.php');
		}*/
	?>
	<title>Think-Parc | Vehicles reporting</title>
	<script>
		// Load charts
		var data_charts2;
		var data_charts3;
		var data_charts4;
		var days_maintenance = 0;
		var days_available = 0;
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		$(function onLoad(){
			document.getElementById("chart1").style.display = "none";
			getAllVehicles();
			$('#date_start').datepicker();
			$('#date_end').datepicker();
		});
		function refreshReport() {
			var sum_parts = 0;
			document.getElementById("chart1").style.display = "block";
			var id_vehicle = document.getElementById("listvehicles").value;
			var date_start = document.getElementById("date_start").value.split("/").reverse().join("-");
			var date_end = document.getElementById("date_end").value.split("/").reverse().join("-");
			var filter = document.getElementById("filter").value;
			getCompany(function(company){
				// Chart for part consumption (maintenance)
				$.ajax({
				  method: "GET",
				  url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehicle/" + id_vehicle + "/daysmaintenance",
				  success: function(data) {
					var response = JSON.parse(data);
					var maintenancedays;
					if (response[0].maintenancedays == null) {
					  maintenancedays = 0;
					} else {
					  maintenancedays = response[0].maintenancedays;
					}
					$.ajax({
					  method: "GET",
					  url: "http://think-parc.com/webservice/v1/companies/vehicles/" + id_vehicle,
					  success: function(data) {
						var responsevehicle = JSON.parse(data);
						var date_buy = new Date(responsevehicle[0].date_buy);
						var date_now = new Date(new Date().yyyymmdd());
						// Draw chart
						days_maintenance = parseInt(maintenancedays);
						days_available = parseInt(((date_now - date_buy) / 86400000) - days_maintenance);
					
						drawChart();
					  },
					  async: false
					});
				  },
				  async: false
				});
				// Chart of Reference / Qty used
				$.ajax({
				  method: "GET",
				  url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/vehicles/usedparts/" + id_vehicle + "/" + date_start + "/" + date_end,
				  success: function(data) {
					var response = JSON.parse(data);
					data_charts2 = new Array(response.length+1);
					data_charts2[0] = new Array( "Reference", "Quantity" );
					for (var i = 1; i<=response.length; i++) {
						data_charts2[i] = new Array( 	response[i-1].reference, 
														parseInt(response[i-1].qt)
													);
					}
					drawChart2();
				  },
				  async: false
				});
				// Chart of type of maintenance
				$.ajax({
				  method: "GET",
				  url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/vehicles/typemaintenance/" + id_vehicle + "/" + date_start + "/" + date_end,
				  success: function(data) {
					var response = JSON.parse(data);
					data_charts3 = new Array(response.length+1);
					data_charts3[0] = new Array( "Type of maintenance", "Quantity" );
					for (var i = 1; i<=response.length; i++) {
						var qt = 0;
						if (response[i-1].cancelnull > 0) {
							qt = parseInt(response[i-1].sumtm);
						}
						data_charts3[i] = new Array( 	response[i-1].typemaintenance, 
														qt
													);
					}
					drawChart3();
				  },
				  async: false
				});
				// Maintenance cost
				$.ajax({
				  method: "GET",
				  url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/maintenance/cost/" + id_vehicle + "/start/" + date_start + "/end/" + date_end + "/filter/" + filter,
				  success: function(data) {
					var response = JSON.parse(data);
					data_charts4 = new Array(response.length+1);
					data_charts4[0] = new Array( "Cost", "€", { role: "style" } );
					for (var i = 1; i<=response.length; i++) {
						var col_name;
						if (filter == "DAY") {
							col_name = reformatDate(response[i-1].f);
						} else if (filter == "MONTH") {
							col_name = response[i-1].f + "/" + response[i-1].y;
						} else if (filter == "YEAR") {
							col_name = response[i-1].y;
						}
						data_charts4[i] = new Array( 	col_name, 
														parseInt(response[i-1].maintcost), 
														"#3366cc" );
					}
					drawChart4();
				  },
				  async: false
				});
			});
		}
		function drawChart() {
			var data;
			  data = google.visualization.arrayToDataTable([
					['Available', 'Maintenance'],
					['Available', days_available],
					['Maintenance', days_maintenance]
				  ]);

			  var options = {
				title: "Available vs Maintenance (global)",
				backgroundColor: {
				  fill: 'transparent'
				},
				pieHole: 0.4,
				titleTextStyle: {
				  color: '#FFF',
				  fontSize: 16,
				  fontStyle: "normal"
				},
				legendTextStyle: {
				  color: '#FFF'
				},
				colors: ['#009933', "#990000"]
			  };

			  var chart = new google.visualization.PieChart(document.getElementById('availablemaintenancedays'));
			  chart.draw(data, options);
			
		}
		function drawChart2() {
			var data;
			if (typeof(data_charts2) != "undefined") {
			  data = google.visualization.arrayToDataTable(data_charts2);
			} else {
			  data = google.visualization.arrayToDataTable([
					['Reference', 'Quantity'],
					['PartA', 1]
				  ]);
			}

			  var options = {
				title: "Used parts",
				backgroundColor: {
				  fill: 'transparent'
				},
				pieHole: 0.4,
				titleTextStyle: {
				  fontSize: 16,
				  fontStyle: "normal",
				  color: '#FFF'
				},
				legendTextStyle: {
				  color: '#FFF'
				}
			  };

			  var chart = new google.visualization.PieChart(document.getElementById('partsused'));
			  chart.draw(data, options);
			
		}
		function drawChart3() {
			var data;
			if (typeof(data_charts3) != "undefined") {
			  data = google.visualization.arrayToDataTable(data_charts3);
			} else {
			  data = google.visualization.arrayToDataTable([
					['Type', 'Quantity'],
					['Guarantee', 0]
				  ]);
			}

			  var options = {
				title: "Type of maintenance",
				backgroundColor: {
				  fill: 'transparent'
				},
				pieHole: 0.4,
				titleTextStyle: {
				  fontSize: 16,
				  fontStyle: "normal",
				  color: '#FFF'
				},
				legendTextStyle: {
				  color: '#FFF'
				},
				colors: ['#E6ED5A', "#BF8273", "#A873BF", "#8ABF73"]
			  };

			  var chart = new google.visualization.PieChart(document.getElementById('typemaintenance'));
			  chart.draw(data, options);
			
		}
		function drawChart4() {
			if (typeof(data_charts4) != "undefined") {
				var data = google.visualization.arrayToDataTable(data_charts4);
				var optionsData = {
					backgroundColor: { fill:'transparent' },
					titleTextStyle: { color: '#FFF' },
					legendTextStyle: { color: '#FFF' },
					vAxis:	{ textStyle: {color: '#FFF' }},
					hAxis: 	{ textStyle: { color: '#FFF' } },
					legend: { position: "right" },
				};
				var view = new google.visualization.DataView(data);
				view.setColumns([ 0, 1, { 	calc: "stringify",
											sourceColumn: 1,
											type: "string",
											role: "annotation" }, 2]);
				var optionsView = {
					title: "Maintenance cost",
					backgroundColor: { fill:'transparent' },
					titleTextStyle: { fontSize: 16, fontStyle: "normal", color: '#FFF' },
					legendTextStyle: { color: '#FFF' },
					bar: {groupWidth: "95%"},
					vAxis:	{ textStyle: {color: '#FFF' }},
					hAxis: 	{ textStyle: { color: '#FFF' } },
					legend: { position: "right" },
					animation:{
						duration: 1000,
						easing: 'in'
					}
				};
				var chart = new google.visualization.ColumnChart(document.getElementById("maintenancecost"));
				chart.draw(data, optionsData);	// 1st draw with data (animate)
				chart.draw(view, optionsView);	// 2nd draw with data & view
			}
		}
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
		/** Retrieves all vehicles */
		function getAllVehicles() {
		  getCompany(function(company) {
			$.ajax({
			  method: "GET",
			  url: "http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all",
			  success: function(data) {
				var response = JSON.parse(data);
				var content = '';
				var contenttable = '';
				for (var i = 0; i < response.length; i++) {
				  content = content + '<option value="' + response[i].id_vehicle + '">' + response[i].nr_plate + '</option>';
				}
				document.getElementById("listvehicles").innerHTML = content;
			  }
			});
		  });
		};
		function reformatDate(dateStr) {
			dArr = dateStr.split("-");
			return dArr[2]+ "/" +dArr[1]+ "/" +dArr[0];
		}
		/** Date prototype JJ/MM/AAAA */
		Date.prototype.yyyymmdd = function() {
		  var yyyy = this.getFullYear().toString();
		  var mm = (this.getMonth() + 1).toString();
		  var dd = this.getDate().toString();
		  return yyyy + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + (dd[1] ? dd : "0" + dd[0]);
		};
	</script>
</head>
<body>

	<?php
		include('../header/navbar.php');
	?>
	
	<img src="../../images/background/maintenance/think_parc_maintenance_5.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad">	
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=reporting">
						<h5><i class="fa fa-chevron-left"></i> Back</h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr>
											<td>
												Vehicles
											</td>
											<td>
												From
											</td>
											<td>
												To
											</td>
											<td>
												Grouping
											</td>
										</tr>
										<tr>
											<td>
												<select id="listvehicles" name="listvehicles" required="required" class="form-control">
													<!-- Retrieve kinds with an AJAX [GET] query -->
												</select>
											</td>
											<td>
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_start" name="date_start" placeholder="JJ/MM/AAAA" required>
											</td>
											<td>
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_end" name="date_end" placeholder="JJ/MM/AAAA" required>
											</td>
											<td>
												<select id="filter" name="filter" class="form-control">
													<option value="DAY">Day</option>
													<option value="MONTH">Month</option>
													<option value="YEAR">Year</option>
												</select>
											</td>
											<td align="right">
												<a href="javascript:refreshReport();">
													<i class="fa fa-search"></i>
												</a>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table-no-border">
									<thead>
										<tr id="chart1">
											<td id="availablemaintenancedays" style="width: 500px; height: auto;">
												
											</td>
											<td id="partsused" style="width: 500px; height: auto;">
												
											</td>
											<td id="typemaintenance" style="width: 500px; height: auto;">
												
											</td>
										</tr>
									</thead>
									<tbody>
										<tr id="chart2">
											<td id="maintenancecost" style="max-height:500px;" colspan="3">
												
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
	<?php
		include('../footer/footer.php');
	?>
</body>
</html>