<?php
/* ======================================================================== *
 *																			*
 * @filename:		addinstock.php											*
 * @description:	This page allows some users to put a product in stock.	*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @lastupdate: 	21/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 21/06/2015 | S.KHALID      | Creation									*
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
		include('../../lang/options/addinstock.fr.php');
		else
		include('../../lang/options/addinstock.en.php');
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="addinstock.js"></script>';
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
							<form class="formimg" name="form1" action="javascript:addinstock();" method="post" enctype="multipart/form-data">
								<table class="table-no-border">
									<tbody>
										<tr>
											<td><h5>* <?php echo $stocks['REFERENCE'];?></h5></td>
										</tr>
										<tr>
											<td>
												 <script>
													var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
												 </script>
												 <input type="text" id="ref" placeholder="<?php echo $stocks['REFERENCE'];?>" onkeyup="checkref(ref, id_company);" class="form-control" required/> 
											</td>
											<td>
												<div id="textDiv"  class="red"/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['QUANTITYANDMEASURE'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="quanty" class="form-control" placeholder="<?php echo $stocks['QUANTITY'];?>" required/>
											</td>
											<td>
												<select required="required" id="measurementContent" class="form-control">
                                             <!-- Here are loaded measurementContent  -->
												</select>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['LOCATION'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="id_measurement" class="form-control" placeholder="<?php echo $stocks['MAGASIN'];?>" required/>
											</td>
											<td>
												<input type="text" id="driveway" class="form-control" placeholder="<?php echo $stocks['DRIVE'];?>" required/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['LOCATION'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="bay" class="form-control" placeholder="<?php echo $stocks['BAY'];?>" required/>
											</td>
											<td>
												<input type="text" id="rack" class="form-control" placeholder="<?php echo $stocks['RACK'];?>" required/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['LOCATION'];?></h5></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="locker" class="form-control" placeholder="<?php echo $stocks['LOCKER'];?>" required/>
											</td>
											<td>
												<input type="text" id="position" class="form-control" placeholder="<?php echo $stocks['POSITION'];?>" required/>
											</td>
										</tr>
										<tr>
											<td><h5><?php echo $stocks['LOCATIONANDTYPE'];?></h5></td>
										</tr>
										<tr>
											<td>
											    <input type="text" id="equivalence" class="form-control" placeholder="<?php echo $stocks['OPTIONAL'];?>"/>
											</td>
											<td>
												<select id="KindsContent" class="form-control" required="required"/>
											</td>
										</tr>
										<tr>
											<td><h5>* <?php echo $stocks['ASSIGNMENTANDSTOREHOUSE'];?></h5></td>
										</tr>
										<tr>
											<td>
												<select id="SitesContent" class="form-control" required="required"/>
											</td>
											<td>
												<input type="text" id="storehouse" class="form-control" placeholder="<?php echo $stocks['STOREHOUSE'];?>"/>
											</td>
										</tr>
										
										<tr>
											<td colspan="2" align="right">
												<input type="reset" value="<?php echo $stocks['RESET'];?>" class="btn btn-warning"/>
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