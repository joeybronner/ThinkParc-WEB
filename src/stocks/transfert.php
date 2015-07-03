<?php
/* ======================================================================== *
 *																			*
 * @filename:		transfert.php											*
 * @description:	This page allows some users to make a transfert product.*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @lastupdate: 	24/06/2015												*
 * @remarks:		-														*
 * 																			*
 * @rights:			Think-Parc Software ©, 2015.							*
 *																			*
 *																			*
 * Date       | Developer      | Changes description						* 
 * ------------------------------------------------------------------------ *
 * 24/06/2015 | S.KHALID      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/
?>
   <html>

   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
		include('../../lang/stocks/transfert.fr.php');
		else
		include('../../lang/stocks/transfert.en.php');
		
		/* 5. Import specific JavaScript file for this page */
		echo '<script type="text/javascript" src="transfert.js"></script>';
		?>
   </head>

   <body>
      <?php include('../header/navbar.php'); ?>

         <img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners" />

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
                                    <td>
                                       <h5><?php echo $stocks['SELECT1'];?></h5></td>
                                 </tr>
                                 <tr>
                                    <td>

                                       <select id="listproducts" name="listproducts" class="form-control" onchange="getSites2(this.value);">
                                          <!-- Retrieve all products with an AJAX [GET] query -->
                                       </select>
                                    </td>

                                 </tr>
                                 <tr>
                                    <td>
                                       <h5><?php echo $stocks['SELECT2'];?></h5></td>
                                 </tr>
                                 <tr>
                                    <td>
                                       <!-- Hidden div(s) for JS values -->
                                       <div id="fct_id_company" name="fct_id_company" style="display: none;">
                                          <?php echo $_SESSION['fct_id_company']; ?>
                                       </div>
                                       <script>
                                          var idsite = document.getElementById('listproducts').value;
                                       </script>
                                       <select id="listproducts2" class="form-control" onchange="getcompanyproduct(fct_id_company, idsite);">
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


         <div id="productblock">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 toppad">
               <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
                     <a href="../accueil.php?section=products">
                        <h5><i class="fa fa-chevron-left"></i><?php echo $stocks['BACK'];?></h5>
                     </a>
                  </div>
               </div>
               <div class="templatemo-content">
                  <div class="black-bg btn-menu margin-bottom-20">
                     <h2><?php echo $stocks['TRANSFER'];?></h2>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-12 col-lg-12">
                              <form>
                                 <div class="col-md-12 col-lg-12">
                                    <div id="stock">
                                    </div>
                                    <center>
                                       <h4><?php echo $stocks['INPUT'];?></h4></center>
                                    <input type="text" id="title" placeholder="<?php echo $stocks['INPUTNAME'];?>" class="transfert-form" />
                                    <br />
                                    <br />
                                    <a href="javascript:check();" class="btn btn-success" />
                                    <?php echo $stocks['SUBMIT'];?>
                                       </a>&nbsp;
                                       <input type="reset" value="<?php echo $stocks['RESET'];?>" class="btn btn-warning" />
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php include('../footer/footer.php'); ?>
   </body>

   </html>