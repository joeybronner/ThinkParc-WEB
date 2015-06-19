<?php
/* ======================================================================== *
 *																			*
 * @filename:		adduser.php												*
 * @description:	This page allows some users to put a brand in dataBase.	*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @lastupdate: 	17/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 17/06/2015 | S.KHALID      | Creation									*
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
		include('../../lang/options/adduser.fr.php');
		else
		include('../../lang/options/adduser.en.php');
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="addmaintenance.js"></script>';
	?>
      
   </head>
   <body>

	<!-- Include navbar with home, informations & logout shortcuts -->
	<?php require(BASE_PATH . '/src/header/navbar.php'); ?>
	
	<!-- Hidden div(s) for JS values -->
	<div id="fct_id_user" style="display: none;"><?php echo $_SESSION['fct_id_user']; ?></div>

	<!-- Background image for this page-->
	<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	
	<!-- Page content -->
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=options">
						<h5><i class="fa fa-chevron-left"></i><?php echo $options['BACK'];?></h5>
				</a>
			</div>
		</div>
	   <div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $options['TITLE_ADDUSER'];?></h2>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> 
							<form class="formimg" action="javascript:adduser(firstname, lastname, login, password, email, image, id_role, id_company);" method="post" enctype="multipart/form-data">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>*<?php echo $options['FIRSTNAMEANDLASTNAME'];?></h5></td>
										</tr>
										<tr>
											<td>
												 
												 <input type="text" id="lastname" placeholder="<?php echo $options['LASTNAME'];?>" class="form-control" required/>
											</td>
											<td>
												<input type="text" id="firstname" placeholder="<?php echo $options['FIRSTNAME'];?>" class="form-control" required/>
											</td>
										</tr>
										<tr>
											<td><h5>*<?php echo $options['LOGINANDEMAIL'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="login" placeholder="<?php echo $options['LOGIN'];?>" class="form-control" required/>
											</td>
											<td>
												<input type="text" id="email" placeholder="<?php echo $options['EMAIL'];?>" class="form-control" required/>
											</td>
										</tr>
										<tr>
											<td><h5>*<?php echo $options['PASSWORDTITLE'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="password" id="password" placeholder="<?php echo $options['PASSWORD'];?>" class="form-control" required/>
											</td>
											<td>
												<input type="password" id="passwordconfirmation" placeholder="<?php echo $options['CONFIRM_PASSWORD'];?>" class="form-control" required/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $options['COMPANYANDROLE'];?></h5></td>
										</tr>
										<tr>
											<td>
												<select id="id_company" name="id_company" class="form-control">
													<!-- Here are loaded company content -->
												 </select>
											</td>
											<td>
												 <select id="id_role" name="id_role" class="form-control">
													<!-- Here are loaded role content -->
												 </select>
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $options['PICTURE'];?></h5></td>
										</tr>
										<tr>
										
											<td colspan="2">
												<h5><input class="form-group" type="file" id="image" name="myfiles"/></h5>
											</td>
										
										</tr>
									
										<tr>
											<td colspan="2" align="right">
												<input type="reset" value="<?php echo $options['RESET'];?>" class="btn btn-warning"/>
												<input type="submit" class="btn btn-success" value="<?php echo $options['SUBMIT'];?>"/>
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
	<?php include('../footer/footer.php'); ?>
</body>
</html>