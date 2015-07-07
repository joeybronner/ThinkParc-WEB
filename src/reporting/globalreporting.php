<?php
/* ======================================================================== *
 *																			*
 * @filename:		globalreporting.php										*
 * @description:	Global reporting 										*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @creation: 		03/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 03/06/2015 | S.KHALID      | Creation									*
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
			include('../../lang/maintenance/globalreporting.fr.php');
		} else {
			include('../../lang/maintenance/globalreporting.en.php');
		}*/
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="globalreporting.js"></script>';
	?>
	<title>Think-Parc | Global reporting</title>


</head>
<body>

	<?php
		include('../header/navbar.php');
	?>
	
	<img src="../../images/background/maintenance/think_parc_maintenance_5.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners"/>
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
												Sites
											</td>
										</tr>
										<tr>
											<td>
												<select id="listproducts" name="listproducts" required="required" class="form-control">
													<!-- Retrieve kinds with an AJAX [GET] query -->
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
											<td id="vehiclesum" style="width: 500px; height: auto;">
											</td>
									
											<td id="vehicleenstock" style="width: 500px; height: auto;">
											</td>
										</tr>
											
										<tr id="title_values">
											<td align="center" colspan="4">
												<h2>Valeur parc automobile</h2>
											</td>
										</tr>	
										<tr>
											<td id="chart4" align="center" colspan="4" style="font-size:4vw">
											</td>
										</tr>
										<tr id="title_valuesofstock">
											<td align="center" colspan="4">
												<h2>Valeur du stock</h2>
											</td>
										</tr>	
										<tr>
											<td id="chart5" align="center" colspan="4" style="font-size:4vw">
											</td>
										</tr>
								
										<tr>
											<td id="stockpart" align="right" colspan="5" style="font-size:5vw">
											</td>
										</tr>
									</thead>
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