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
		if($_SESSION['fct_lang'] == 'FR') {
			include('../../lang/reporting/partsconsumption.fr.php');
		} else {
			include('../../lang/reporting/partsconsumption.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="partsconsumption.js"></script>';
	?>
	<title><?php echo $partsconsump['PAGE_TITLE']; ?></title>
</head>
<body>

	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>
	
	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/maintenance/think_parc_maintenance_5.jpg">
	
	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>
	
	<!-- Page content -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad">	
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=reporting">
						<h5><i class="fa fa-chevron-left"></i><?php echo $partsconsump['BACK']; ?></h5>
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
											<td width="25%">
												<?php echo $partsconsump['REFERENCE']; ?>
											</td>
											<td width="25%">
												<?php echo $partsconsump['FROM']; ?>
											</td>
											<td width="25%">
												<?php echo $partsconsump['TO']; ?>
											</td>
											<td width="25%" colspan="2">
												<?php echo $partsconsump['GROUPING']; ?>
											</td>
										</tr>
										<tr>
											<td width="25%">
												<select id="reference" name="reference" required="required" class="form-control">
													<!-- Retrieve kinds with an AJAX [GET] query -->
												</select>
											</td>
											<td width="25%">
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_start" name="date_start" placeholder="JJ/MM/AAAA" required>
											</td>
											<td width="25%">
												<input type="text" class="form-control" data-date-format="dd/mm/yyyy" id="date_end" name="date_end" placeholder="JJ/MM/AAAA" required>
											</td>
											<td width="20%">
												<select id="filter" name="filter" class="form-control">
													<option value="DAY"><?php echo $partsconsump['DAY']; ?></option>
													<option value="MONTH"><?php echo $partsconsump['MONTH']; ?></option>
													<option value="YEAR"><?php echo $partsconsump['YEAR']; ?></option>
												</select>
											</td>
											<td width="5%" align="right">
												<a href="javascript:refreshReport();">
													<i class="fa fa-search"></i>
												</a>
											</td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="partsconsumptionreporting" class="black-bg btn-menu" style="display:none;">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form>
								<table class="table-no-border">
									<tbody>
										<tr id="title_chart1">
											<td width="100%" colspan="5">
												<center>
													<h2><?php echo $partsconsump['CONSUM_MAINTEN']; ?></h2>
												</center>
											</td>
										</tr>
										<tr id="chart1">
											<td id="columnchart_values" style="max-height:500px;" width="100%" colspan="5">
												
											</td>
										</tr>
										<tr id="chart2">
											<td id="sum_parts" style="font-size:5vw" align="right" colspan="2">
											
											</td>
											<td id="text_usedparts" style="font-size:2vw" colspan="3">
												 
											</td>
										</tr>
										<tr id="title_chart3">
											<td style="padding-top:20px;" width="100%" colspan="5">
												<center>
													<h2><?php echo $partsconsump['CONSUM_TRANSFE']; ?></h2>
												</center>
											</td>
										</tr>
										<tr id="chart3">
											<td id="consumptiontransfert_values" style="max-height:500px;" width="100%" colspan="5">
												
											</td>
										</tr>
										<tr id="title_chart4">
											<td align="center" width="100%" colspan="5">
												<h2><?php echo $partsconsump['QT_STOCK']; ?></h2>
											</td>
										</tr>
										<tr>
											<td id="chart4" align="center" style="font-size:4vw" width="100%" colspan="5">
												-
											</td>
										</tr>
										<tr id="title_chart5">
											<td align="center" width="100%" colspan="5">
												<h2><?php echo $partsconsump['MARKET_VALUE']; ?></h2>
											</td>
										</tr>
										<tr>
											<td id="chart5" align="center" style="font-size:4vw" width="100%" colspan="5">
												-
											</td>
										</tr>
										<tr id="title_chart6">
											<td width="100%" colspan="5">
												<center><h2><?php echo $partsconsump['PARTS_LOCALISATION']; ?></h2></center>
											</td>
										</tr>
										<tr id="chart6">
											<td id="partslocalisation_values" width="100%" align="center" style="height:200px;" colspan="5">
												-
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
	<!-- End page content -->
	
	<!-- Include footer bar with language switch & global website informations -->
	<?php require(BASE_PATH . '/src/footer/footer.php'); ?>
</body>
</html>