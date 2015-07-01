<?php
/* ======================================================================== *
 *																			*
 * @filename:		addproduct.php											*
 * @description:	This page allows to put a product in dataBase.			*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @lastupdate: 	23/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 23/06/2015 | S.KHALID      | Creation									*
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
		include('../../lang/options/addproduct.fr.php');
		else
		include('../../lang/options/addproduct.en.php');
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="addproduct.js"></script>';
		?>
   </head>
   <body>

	<?php
		include('../header/navbar.php');
	?>

	<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
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
							<form class="formimg" action="javascript:addProduct();" method="post" enctype="multipart/form-data">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* <?php echo $stocks['FAMILY'];?></h5></td>
										</tr>
										<tr>
											<td class="small">
												 <select id="familyContent" name="familyContent" class="form-control"" onchange="getUnderFamily(this.value);">
													<!-- Here are loaded Family content -->
												 </select>
											</td >
											<td class="small">
												<select id="underfamilyContent" name="underfamilyContent" class="form-control" onchange="getUnderFamily2(this.value);">
													 <!-- Here are loaded Under Family content -->
												 </select>
											</td>
											<td class="small">
												 <select id="underfamilyContent2" name="underfamilyContent2" class="form-control">
													<!-- Here are loaded Under N2 Family content -->
												 </select>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['REFANDDESIGNATION'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="reference" placeholder="<?php echo $stocks['REFERENCE'];?>" class="form-control" required/>
											</td>
											<td>
												<input type="text" id="designation" placeholder="<?php echo $stocks['DESIGNATION'];?>" class="form-control" required/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['PRICE'];?></h5></td>
										</tr>
										<tr>
											<td>
												 <input type="text" id="buyingprice" placeholder="<?php echo $stocks['PRICE'];?>" class="form-control" required/>
											</td>
											<td>
												 <select id="CurrenciesContent" class="form-control" required/>
                                          
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $stocks['BRANDANDCOM'];?></h5></td>
										</tr>
										<tr>
											<td>
												 <input type="text" id="brand" placeholder="<?php echo $stocks['BRAND'];?>" class="form-control"/>
											</td>
											<td>
												 <input type="text" id="com" placeholder="<?php echo $stocks['COM'];?>" class="form-control"/>
											</td>
										</tr>
										<tr>
											<td colspan="3" align="right">
												<input type="reset" value="<?php echo $stocks['RESET'];?>" class="btn btn-warning" onclick="OnResetClick();"/>
												<input type="submit" class="btn btn-success" value="<?php echo $stocks['SUBMIT'];?>"/>
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