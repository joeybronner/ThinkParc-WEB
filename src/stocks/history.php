<?php
/* ======================================================================== *
 *																			*
 * @filename:		history.php												*
 * @description:	This page allows some users to see history of transfert.*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @lastupdate: 	26/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 26/06/2015 | S.KHALID      | Creation									*
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
		if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/options/history.fr.php');
		else
		include('../../lang/options/history.en.php');
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="history.js"></script>';
		?>
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners"/>
		
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
									<form>
										<table class="table-no-border">
												<tr>
													<td><h5><?php echo $stocks['SELECT'];?></h5></td>
												</tr>
												<tr>
													<td>
													<script>
														var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
													</script>
														<select id="list" name="list" class="form-control" onchange="gethistory(this.value);">
															<!-- Retrieve all products with an AJAX [GET] query -->
														</select>
													</td>
												</tr>
										</table>
									</form>
								</div>
							</div>
						</div>
				</div>	
			</div>
	</div>
		
	<div id="productblock">	
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2><?php echo $stocks['HISTORY'];?></h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12">
										<div id="stock">
									    </div>	
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>				
	</div>
	<!-- End page content -->
	<!-- Include footer bar with language switch & global website informations -->
	<?php include('../footer/footer.php'); ?>
  </body>
</html>