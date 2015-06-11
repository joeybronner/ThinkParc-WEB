<?php
/* ------------------------------------------------------------------------ *
 *																			*
 * @description:	Description.											*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @lastupdate: 	05/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 * ------------------------------------------------------------------------ */
	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/maintenance/maintenance.fr.php');
	else
		include('../../lang/maintenance/maintenance.en.php');
?>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $maintenance['PAGE_TITLE'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/templatemo_main.css">
	<link rel="stylesheet" href="../../css/app.css">
	<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
	<link rel="stylesheet" href="../../css/DataTable/jquery.dataTables_themefct.css">
	<script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery.backstretch.min.js"></script>
	<script src="../../js/templatemo_script.js"></script>
	<script src="../../js/bootstrap.js"></script>
	<script src="../../js/jquery.toast.js"></script>
	<script src="../../js/popup.js"></script>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery.dataTables.js"></script>	  
	<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	
	<script type="text/javascript" src="../../js/googlecharts.js"></script>
	<script>
		// Load charts
		var data_charts1;
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		$(function onLoad(){
			document.getElementById("title_chart1").style.display = "none";
		});
		function refreshReport() {
			var sum_parts = 0;
			document.getElementById("title_chart1").style.display = "block";
			var reference = document.getElementById("reference").value;
			var date_start = document.getElementById("date_start").value;
			var date_end = document.getElementById("date_end").value;
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
										data_charts1[i] = new Array( 	response[i-1].f + "/" + response[i-1].y, 
																		parseInt(response[i-1].somme), 
																		"#FFB74D" );
									}
									drawChart();
									document.getElementById("sum_parts").innerHTML = sum_parts;
									document.getElementById("text_usedparts").innerHTML = "parts used between " + 
																								date_start + 
																								" and " + 
																								date_end;
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
	</script>
</head>
<body>

	<?php
		include('../header/navbar.php');
	?>
	
	<img src="../../images/background/maintenance.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad">	
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=maintenance">
						<h5><i class="fa fa-chevron-left"></i><?php echo $maintenance['BACK'];?></h5>
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
												<input data-format="yyyy-mm-dd" class="form-control" type="date" id="date_start" required/>
											</td>
											<td>
												<input data-format="yyyy-mm-dd" class="form-control" type="date" id="date_end" required/>
											</td>
											<td>
												<select id="filter" name="filter" class="form-control">
													<option value="day">Day</option>
													<option value="week">Week</option>
													<option value="month">Month</option>
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