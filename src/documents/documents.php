<?php
/* ======================================================================== *
 *																			*
 * @filename:		documents.php											*
 * @description:	This page allows a user to search and upload files		*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @lastupdate: 	23/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 16/06/2015 | J.BRONNER      | Creation									*
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
			include('../../lang/documents/documents.fr.php');
		} else {
			include('../../lang/documents/documents.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="documents.js"></script>';
	?>
	<title><?php echo $maintenance['TITLE_DOCUMENTS'];?></title>
</head>
<body>
	
	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>

	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/home/think_parc_home_2.jpg">

	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>
	
	<!-- Page content -->
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php">
						<h5><i class="fa fa-chevron-left"></i> <?php echo $documents['BACK'];?></h5>
				</a>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-right margin-bottom-20">
				<div align="right">
					<h5>
						<a href="javascript:popup('custompopup');">
							<i id="iconManageFile" class="fa fa-plus-circle"></i>
							 <?php echo $documents['ADD_FILE'];?>
						</a>
					</h5>
				</div>
			</div>
		</div>
		<div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<div class="panel-body">
					<ul class="nav nav-tabs" style="margin-bottom:20px;">
						<li id="tab-global" class="active">
							<a href="javascript:displayGlobal();">Documents globaux</a>
						</li>
						<li id="tab-vehicles">
							<a href="javascript:displayVehicles();">Documents véhicules</a>
						</li>
						<li id="tab-technical">
							<a href="javascript:displayTechnical();">Documents techniques</a>
						</li>
					</ul>
					<div id="documents">
						<!-- Here, DataTable of list of files -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End page content -->
	
	<!-- PopUp section -->
	<div id="blanket" style="display:none"></div>
	<div id="custompopup" style="display:none">
			<div class="panel-body">
				<div class="row"> 
					<form id="addfile" action="javascript:uploadFile();" method="POST">
						<table style="width:100%;">
							<tbody>
								<tr>
									<td colspan="2" id="files">
										<table class="display" id="fileslist">
											
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Fichier</h5>
									</td>
									<td>
										<h5><input class="form-group" type="file" id="file-select" name="myfiles"/></h5>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input type="button" class="btn btn-danger" onclick="javascript:cancelAddFile();" value="Cancel"/>
										<button type="submit" id="upload-button" class="btn btn-success"><?php echo $documents['UPLOAD'];?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
	</div>
	<!-- End PopUp section -->

	<!-- Include footer bar with language switch & global website informations -->
	<?php require(BASE_PATH . '/src/footer/footer.php'); ?>
</body>
</html>