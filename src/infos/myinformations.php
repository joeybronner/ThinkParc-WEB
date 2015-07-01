<?php
/* ======================================================================== *
 *																			*
 * @filename:		myinformations.php										*
 * @description:	This page retrieves all user's informations.			*
 *					Each user can update his profile picture and his		*
 *					password.												*
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
			include('../../lang/infos/infos.fr.php');
		} else {
			include('../../lang/infos/infos.en.php');
		}
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="myinformations.js"></script>';
	?>
	<title><?php echo $maintenance['TITLE_MYINFORMATIONS'];?></title>
</head>
<body>

	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>

	<!-- Background image for this page-->
	<img id="menu-img" class="main-img inactive" src="../../images/background/home/think_parc_home_1.jpg">

	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>
	
	<!-- Page content -->	
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $infos['MYINFORMATIONS'];?></h2>
				<div class="panel-body">
				  <div class="row">
					<div class="col-md-3 col-lg-3 " align="center">
						<img alt="userpic" id="userpic" style="margin:10px;" class="img-circle imguser">
					</div>
					<div class=" col-md-9 col-lg-9 "> 
					  <table class="table table-user-information">
						<tbody>
						  <tr width="100%">
							<td width="35%" class="info_title">ID</td>
							<td width="65%" id="id_user"><?php echo $_SESSION['fct_id_user']; ?></td>
						  </tr>
						  <tr>
							<td width="35%" class="info_title"><?php echo $infos['FIRSTNAME'];?></td>
							<td width="65%" id="firstname"></td>
						  </tr>
						  <tr>
							<td width="35%" class="info_title"><?php echo $infos['LASTNAME'];?></td>
							<td width="65%" id="lastname"></td>
						  </tr>
						  <tr>
							<td width="35%" class="info_title"><?php echo $infos['LOGIN'];?></td>
							<td width="65%" id="login"></td>
						  </tr>
						  <tr>
							<td width="35%" class="info_title"><?php echo $infos['EMAIL'];?></td>
							<td width="65%" id="email"></td>
						  </tr>
						  <tr>
							<td width="35%" class="info_title"><?php echo $infos['PASSWORD'];?></td>
							<td width="65%" >********</td>
						  </tr>
						  <tr>
							<td width="35%" class="info_title"><?php echo $infos['PROFILEPICTURE'];?></td>
							<td width="65%" id="image"></td>
						  </tr>
						</tbody>
					  </table>
					</div>
				  </div>
				</div>
			</div>
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $infos['CHANGE_PASSWORD'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">		
							<div class="input-group input-group-sm">
								<form id="formpassword" class="formimg" action="javascript:updatePassword(<?php echo $_SESSION['fct_id_user']; ?>);" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="form-group col-xs-9" align="left">
											<input type="password" class="form-control" style="margin-bottom:3px;" id="oldpass" name="oldpass" placeholder="<?php echo $infos['OLD_PASSWORD'];?>" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" style="margin-bottom:3px;" id="newpass" name="newpass" placeholder="<?php echo $infos['NEW_PASSWORD'];?>" aria-describedby="sizing-addon3">
											<input type="password" class="form-control" id="confpass" name="confpass" placeholder="<?php echo $infos['CONFIRM_PASSWORD'];?>" aria-describedby="sizing-addon3">
										</div>
										<div class="form-group col-xs-3" align="right">
											<input type="submit" class="btn btn-success" name="submit" value="<?php echo $infos['SUBMIT'];?>">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>		
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $infos['CHANGE_PROFILEPICTURE'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">		
							<form id="file-form" action="javascript:uploadFile(<?php echo $_SESSION['fct_id_user']; ?>);" method="POST">
									<table>
										<tr>
											<td width="75%">
												<h5><input class="form-group" type="file" id="file-select" name="myfiles"/></h5>
											</td>
											<td width="25%" align="right">
												<button type="submit" id="upload-button" class="btn btn-success"><?php echo $infos['UPLOAD'];?></button>
											</td>
										</tr>
									</table>
							</form>
						</div>
					</div>
				</div>
			</div>
			
			<?php
			if ($_SESSION['fct_id_role'] == 1) {
			?>
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $infos['NEWS_MANAGEMENT'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12" align="center">
							<div class="row">
								<form class="formimg" action="javascript:addNews(<?php echo $_SESSION['fct_id_user']; ?>);" method="post" enctype="multipart/form-data">
									<div class="form-group col-xs-9" align="left">
										<textarea id="newstext" name="newstext" class="form-control" rows="3" maxlength="140" placeholder="<?php echo $infos['PUBLISH_NEWS'];?>"></textarea>
									</div>
									<div class="form-group col-xs-3" align="right">
										<input type="submit" class="btn btn-success" name="submit" value="Publier">
									</div>
								</form>
								<div id="post_actif_" class="form-group col-xs-12">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>
	<!-- End page content -->

	<!-- Include footer bar with language switch & global website informations -->
	<?php require(BASE_PATH . '/src/footer/footer.php'); ?>
</body>
</html>
