<?php
/* ======================================================================== *
 *																			*
 * @filename:		partsconsumption.php									*
 * @description:	Reporting for a specific part between a range of date	*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @creation: 		05/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 05/06/2015 | J.BRONNER      | Creation									*
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
	<title>Think-Parc | Parts reporting</title>
	<script>
		// Load charts
		var data_charts1;
		var data_charts3;
		var data_charts6;
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart6);
		$(function onLoad(){
			document.getElementById("title_chart1").style.display = "none";
			document.getElementById("title_chart3").style.display = "none";
			document.getElementById("title_chart4").style.display = "none";
			document.getElementById("chart4").style.display = "none";
			document.getElementById("title_chart5").style.display = "none";
			document.getElementById("chart5").style.display = "none";
			document.getElementById("title_chart6").style.display = "none";
			getAllReferences();
			$('#date_start').datepicker();
			$('#date_end').datepicker();
		});
		function refreshReport() {
			var sum_parts = 0;
			document.getElementById("title_chart1").style.display = "block";
			document.getElementById("title_chart3").style.display = "block";
			document.getElementById("title_chart4").style.display = "block";
			document.getElementById("chart4").style.display = "block";
			document.getElementById("title_chart5").style.display = "block";
			document.getElementById("chart5").style.display = "block";
			document.getElementById("title_chart6").style.display = "block";
			var reference = document.getElementById("reference").value;
			var date_start = document.getElementById("date_start").value.split("/").reverse().join("-");
			var date_end = document.getElementById("date_end").value.split("/").reverse().join("-");
			var filter = document.getElementById("filter").value;
			getCompany(function(company){
				// Chart for part consumption (maintenance)
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/reporting/" +
																	"reference/" + reference +
																	"/start/" + date_start +
																	"/end/" + date_end +
																	"/filter/" + filter,  
					success:	function(data) {
									var response = JSON.parse(data);
									data_charts1 = new Array(response.length+1);
									data_charts1[0] = new Array( "Part", "Used", { role: "style" } );
									for (var i = 1; i<=response.length; i++) {
										sum_parts = sum_parts + parseInt(response[i-1].somme);
										var col_name;
										if (filter == "DAY") {
											col_name = reformatDate(response[i-1].f);
										} else if (filter == "MONTH") {
											col_name = response[i-1].f + "/" + response[i-1].y;
										} else if (filter == "YEAR") {
											col_name = response[i-1].y;
										}
										
										data_charts1[i] = new Array( 	col_name, 
																		parseInt(response[i-1].somme), 
																		"#FFB74D" );
									}
									drawChart();
									document.getElementById("sum_parts").innerHTML = sum_parts;
									document.getElementById("text_usedparts").innerHTML = "parts used for maintenance between " + 
																								reformatDate(date_start) + 
																								" and " + 
																								reformatDate(date_end);
								}
				});
				// Chart for part consumption (transfert)
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/reporting/" +
																	"reference/transfert/" + reference +
																	"/start/" + date_start +
																	"/end/" + date_end +
																	"/filter/" + filter,  
					success:	function(data) {
									var response = JSON.parse(data);
									data_charts3 = new Array(response.length+1);
									data_charts3[0] = new Array( "Part", "Transfert", { role: "style" } );
									for (var i = 1; i<=response.length; i++) {
										sum_parts = sum_parts + parseInt(response[i-1].somme);
										var col_name;
										if (filter == "DAY") {
											col_name = reformatDate(response[i-1].f);
										} else if (filter == "MONTH") {
											col_name = response[i-1].f + "/" + response[i-1].y;
										} else if (filter == "YEAR") {
											col_name = response[i-1].y;
										}
										
										data_charts3[i] = new Array( 	col_name, 
																		parseInt(response[i-1].somme), 
																		"#BADC88" );
									}
									drawChart3();
								}
				});
				// Stock quantity & Market value
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/reporting/reference/" + reference + "/stockvalue",  
					success:	function(data) {
									var response = JSON.parse(data);
									document.getElementById("chart4").innerHTML = response[0].stockquantity;
									document.getElementById("chart5").innerHTML = response[0].marketvalue + " " + response[0].symbol;
								}
				});
				// Draw chart by sites
				$.ajax({
					method: 	"GET",
					url:		"http://think-parc.com/webservice/v1/companies/" + company + "/reporting/reference/" + reference + "/localisation",  
					success:	function(data) {
									var response = JSON.parse(data);
									data_charts6 = new Array(response.length+1);
									data_charts6[0] = new Array( "Site", "Quantity" );
									for (var i = 1; i<=response.length; i++) {
										data_charts6[i] = new Array( 	response[i-1].name, 
																		parseInt(response[i-1].partssum)
																	);
									}
									drawChart6();
								}
				});
			});
		}
		function drawChart6() {
			var data;
			if (typeof(data_charts6) != "undefined") {
			  data = google.visualization.arrayToDataTable(data_charts6);
			} else {
			  data = google.visualization.arrayToDataTable([
					['Site', 'Quantity'],
					['SiteA', 0],
					['SiteB', 0]
				  ]);
			}

			  var options = {
				backgroundColor: {
				  fill: 'transparent'
				},
				pieHole: 0.4,
				titleTextStyle: {
				  color: '#FFF'
				},
				legendTextStyle: {
				  color: '#FFF'
				},
				/*colors: ['#009933', "#990000"]*/
			  };

			  var chart = new google.visualization.PieChart(document.getElementById('partslocalisation_values'));
			  chart.draw(data, options);
			
		}
		function drawChart3() {
			if (typeof(data_charts3) != "undefined") {
				var data = google.visualization.arrayToDataTable(data_charts3);
				var optionsData = {
					backgroundColor: { fill:'transparent' },
					titleTextStyle: { color: '#FFF' },
					legendTextStyle: { color: '#FFF' },
					vAxis:	{ textStyle: {color: '#FFF' }},
					hAxis: 	{ textStyle: { color: '#FFF' } },
					legend: { position: "none" },
				};
				var view = new google.visualization.DataView(data);
				view.setColumns([ 0, 1, { 	calc: "stringify",
											sourceColumn: 1,
											type: "string",
											role: "annotation" }, 2]);
				var optionsView = {
					backgroundColor: { fill:'transparent' },
					titleTextStyle: { color: '#FFF' },
					legendTextStyle: { color: '#FFF' },
					bar: {groupWidth: "95%"},
					vAxis:	{ textStyle: {color: '#FFF' }},
					hAxis: 	{ textStyle: { color: '#FFF' } },
					legend: { position: "none" },
					animation:{
						duration: 1000,
						easing: 'in'
					}
				};
				var chart = new google.visualization.ColumnChart(document.getElementById("consumptiontransfert_values"));
				chart.draw(data, optionsData);	// 1st draw with data (animate)
				chart.draw(view, optionsView);	// 2nd draw with data & view
			}
		}
		function drawChart() {
			if (typeof(data_charts1) != "undefined") {
				var data = google.visualization.arrayToDataTable(data_charts1);
				var optionsData = {
					backgroundColor: { fill:'transparent' },
					titleTextStyle: { color: '#FFF' },
					legendTextStyle: { color: '#FFF' },
					vAxis:	{ textStyle: {color: '#FFF' }},
					hAxis: 	{ textStyle: { color: '#FFF' } },
					legend: { position: "none" },
				};
				var view = new google.visualization.DataView(data);
				view.setColumns([ 0, 1, { 	calc: "stringify",
											sourceColumn: 1,
											type: "string",
											role: "annotation" }, 2]);
				var optionsView = {
					backgroundColor: { fill:'transparent' },
					titleTextStyle: { color: '#FFF' },
					legendTextStyle: { color: '#FFF' },
					bar: {groupWidth: "95%"},
					vAxis:	{ textStyle: {color: '#FFF' }},
					hAxis: 	{ textStyle: { color: '#FFF' } },
					legend: { position: "none" },
					animation:{
						duration: 1000,
						easing: 'in'
					}
				};
				var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
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
		function getAllReferences() {
			getCompany(function(company) {
			  $.ajax({
				  method: "GET",
				  url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/parts/all",
				  success: function(data) {
					var response = JSON.parse(data);
					var content = '';
					for (var i = 0; i < response.length; i++) {
					  content = content + '<option value="' + response[i].reference + '">' + response[i].reference + '</option>';
					}
					document.getElementById("reference").innerHTML = content;
				  }
				});
			});
		}
		function reformatDate(dateStr) {
			dArr = dateStr.split("-");
			return dArr[2]+ "/" +dArr[1]+ "/" +dArr[0];
		}
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
						<h5><i class="fa fa-chevron-left"></i>Back</h5>
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
												Reference
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
												<select id="reference" name="reference" required="required" class="form-control">
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
										<tr id="title_chart1">
											<td style="padding-top:20px;" colspan="4">
												<center>
													<h2>Parts consumed for maintenance</h2>
												</center>
											</td>
										</tr>
										<tr id="chart1">
											<td id="columnchart_values" style="max-height:500px;" colspan="4">
												
											</td>
										</tr>
										<tr id="chart2">
											<td id="sum_parts" style="font-size:5vw" align="right">
											
											</td>
											<td id="text_usedparts" style="font-size:2vw" colspan="3">
												 
											</td>
										</tr>
										<tr id="title_chart3">
											<td style="padding-top:20px;" colspan="4">
												<center>
													<h2>Parts transfered between different sites</h2>
												</center>
											</td>
										</tr>
										<tr id="chart3">
											<td id="consumptiontransfert_values" style="max-height:500px;" colspan="4">
												
											</td>
										</tr>
										<tr id="title_chart4">
											<td align="center" colspan="4">
												<h2>Quantity in stock</h2>
											</td>
										</tr>
										<tr>
											<td id="chart4" align="center" colspan="4" style="font-size:4vw">
												-
											</td>
										</tr>
										<tr id="title_chart5">
											<td align="center" colspan="4">
												<h2>Market value</h2>
											</td>
										</tr>
										<tr>
											<td id="chart5" align="center" colspan="4" style="font-size:4vw">
												-
											</td>
										</tr>
										<tr id="title_chart6">
											<td align="center" colspan="3">
												<h2>Parts localisation</h2>
											</td align="center">
											<td id="partslocalisation_values" style="max-height:500px; margin: 0 auto;" colspan="4">
													
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