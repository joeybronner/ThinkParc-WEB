<?php
   require_once('../../db/config.php'); 
   include('../../db/db_functions.php');
   session_start();
   $dbh = new db_functions();
   ?>
<html>
   <head>
      <title>FCT</title>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="../../css/bootstrap.css">
      <link rel="stylesheet" href="../../css/font-awesome.min.css">
      <link rel="stylesheet" href="../../css/templatemo_main.css">
      <link rel="stylesheet" href="../../css/app.css">
      <link rel="stylesheet" href="../../css/toast/jquery.toast.css">
      <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
      <script src="../../js/jquery.min.js"></script>
      <script src="../../js/jquery-ui.min.js"></script>
      <script src="../../js/jquery.backstretch.min.js"></script>
      <script src="../../js/templatemo_script.js"></script>
      <script src="../../js/bootstrap.js"></script>
      <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
      <script type="text/javascript" src="../../js/jquery.toast.js"></script>
   </head>
   <body>
      <?php include('../header/navbar.php');
         $privilege = $_SESSION['fct_privilege'];
         ?>
      <img src="../../images/zoom-bg-5.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
      <div class="templatemo-content">
         <div class="black-bg btn-menu margin-bottom-20">
            <h2>Fiche produit</h2>
            <div class="panel-body">
               <div class="row">
                  <div class=" col-md-9 col-lg-11 ">
                     <form action="recordproduct.php" method="GET">
                        <table class="table table-user-information">
                           <tbody>
                              <tr>
                                 <td><b>Familles</b></td>
                                 <td class="infos">
                                    <select name="famille" class="large" >
                                       <option selected disabled>Famille</option>
                                       <?php 
                                          $dbh = new db_functions();
                                          foreach ($dbh->getfamille() as $Valeur)
                                          {
                                          ?>
                                       <option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['libelle'];?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <select name="sousfamille" class="large" >
                                       <option selected disabled>Sous famille</option>
                                       <?php 
                                          $dbh = new db_functions();
                                          foreach ($dbh->getsousfamille1() as $Valeur)
                                          {
                                          ?>
                                       <option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['libelle'];?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <select name="sousfamille2" class="large" >
                                       <option selected disabled>Sous famille N2</option>
                                       <?php 
                                          $dbh = new db_functions();
                                          foreach ($dbh->getsousfamille2() as $Valeur)
                                          {
                                          ?>
                                       <option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['libelle'];?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <select name="sousfamillen3" class="large" >
                                       <option selected disabled>Sous famille N3</option>
                                       <?php 
                                          $dbh = new db_functions();
                                          foreach ($dbh->getsousfamille3() as $Valeur)
                                          {
                                          ?>
                                       <option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['libelle'];?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td><b>R&eacute;f&eacute;rence constructeur</b></td>
                                 <td><input type="text" name="reference"></td>
                              </tr>
                              <tr>
                                 <td><b>D&eacute;signation de la pi&egrave;ce</b></td>
                                 <td><input type="text" name="designation"></td>
                              </tr>
                              <tr>
                                 <td><b>Type de pi&egrave;ce</b></td>
                                 <td>
                                    <select name="type" class="large" >
                                       <option selected disabled>Choix</option>
                                       <?php 
                                          $dbh = new db_functions();
                                          foreach ($dbh->gettype() as $Valeur)
                                          {
                                          ?>
                                       <option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['libelle'];?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td><b>Prix d'achat</b></td>
                                 <td>
                                    <input type="text" name="prix" class="small">
                                    <select name="devise" class="small" >
                                       <option selected disabled>devise</option>
                                       <option value="euro">Euro</option>
                                       <option value="usd">USD</option>
                                       <option value="dinhar">Dinhar</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td><b>Quantit&eacute;e en stock</b></td>
                                 <td>
                                    <input type="text" name="quantite" class="small">
                                    <a href="stockmultisite.php" target="_blank"><i>voir le stock multi site</i></a>
                                 </td>
                              </tr>
                              <tr>
                                 <td><b>Emplacements</b></td>
                                 <td>
                                    <input type="text" name="prix" class="large" placeholder="Magasin No">&nbsp;
                                    <input type="text" name="prix" class="large" placeholder="Allee">&nbsp;
                                    <input type="text" name="prix" class="large" placeholder="Travee">&nbsp;
                                    <input type="text" name="prix" class="large" placeholder="Etage">&nbsp;
                                    <input type="text" name="prix" class="large" placeholder="Casier">&nbsp;
                                    <input type="text" name="prix" class="large" placeholder="Position">
                                 </td>
                              </tr>
                              <tr>
                                 <td><b>Equivalence</b></td>
                                 <td>
                                    <input type="text" name="prix" class="large" placeholder="facultatif">
                                 </td>
                              </tr>
                              <tr>
                                 <td><b>Affectation</b></td>
                                 <td>
                                    <select name="affectation_piece" class="large" >
                                       <option selected disabled>Destin&eacute; a</option>
                                       <?php 
                                          $dbh = new db_functions();
                                          foreach ($dbh->getaffectationpiece() as $Valeur)
                                          {
                                          ?>
                                       <option value="<?php echo $Valeur['id'];?>"><?php echo $Valeur['libelle'];?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td><b>D&eacute;pot</b></td>
                                 <?php 
                                    //$count = $dbh->getnbpiece(); 
                                    ?>
                                 <td><?php //ECHO 'Lieu : '.$count['total']; ?></td>
                              </tr>
                              </tr>
                              <tr>
                                 <td><b>Fichiers techniques</b></td>
                                 <td><a href="fichierstock.php">Espace t&eacute;l&eacute;chargement</a></td>
                              </tr>
                              </tr>
                              <tr>
                                 <td></td>
                                 <td>
                                    <input type="submit" value="Valider" class="btn btn-success">&nbsp;<input type="reset" value="Reinitialiser" class="btn btn-warning">
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
   </body>
</html>