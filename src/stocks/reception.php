<?php
/* ======================================================================== *
 *																			*
 * @filename:		reception.php											*
 * @description:	This page allows to recept stock from another site.		*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @lastupdate: 	25/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 25/06/2015 | S.KHALID      | Creation									*
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
		include('../../lang/options/reception.fr.php');
		else
		include('../../lang/options/reception.en.php');
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="reception.js"></script>';
		?>
<html>
	<head>
		<title>FCT Partners</title>
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
		<meta name="description" content="">
		<meta charset="utf-8">
		<link rel="stylesheet" href="../../css/bootstrap.css">
		<link rel="stylesheet" href="../../css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">
		<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
		<link rel="stylesheet" href="../../css/DataTable/jquery.dataTables_themefct.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/jquery-ui.min.js"></script>
		<script src="../../js/jquery.backstretch.min.js"></script>
		<script src="../../js/templatemo_script.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script type="text/javascript" src="../../js/jquery.toast.js"></script>
		<script type="text/javascript" src="../../js/jquery.dataTables.js"></script>  
		<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	
		
		<script>
	
		
		
		
		</script>
		
		
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
											<td><h5><?php echo $stocks['SELECTTRANSFER'];?></h5></td>
										</tr>
										<tr>
											<td>
												<select id="transfertlist" class="form-control" onchange="getalltransferts(id_company, this.value);">
												<!-- Retrieve  with an AJAX [GET] query -->
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
				
	<div id="transferblock">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2><?php echo $stocks['TABLETITLE'];?></h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12">
										<div id="transfert">
									    </div>	
										<a href="javascript:receptioncheck();" class="btn btn-success"><?php echo $stocks['RECEIVE'];?></a>
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