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
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		$(function onLoad(){
			document.getElementById("title_chart1").style.display = "none";
			$('#date_start').datepicker();
			$('#date_end').datepicker();
		});
		function refreshReport() {
			var sum_parts = 0;
			document.getElementById("title_chart1").style.display = "block";
			var reference = document.getElementById("reference").value;
			var date_start = document.getElementById("date_start").value.split("/").reverse().join("-");
			var date_end = document.getElementById("date_end").value.split("/").reverse().join("-");
			var filter = document.getElementById("filter").value;
			getCompany(function(company){
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
									document.getElementById("text_usedparts").innerHTML = "parts used between " + 
																								reformatDate(date_start) + 
																								" and " + 
																								reformatDate(date_end);
								}
				});
			});
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
												<input type="text" class="form-control" id="reference" placeholder="Here, type the part reference" />
												<!--<select id="listvehicles" name="listvehicles" class="form-control">-->
													<!-- Retrieve all vehicles with an AJAX [GET] query -->
												<!--</select>-->
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
													<h2>Part using by month</h2>
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