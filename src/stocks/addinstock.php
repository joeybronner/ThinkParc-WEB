<?php
   session_start();
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
      <script>
         $(function getFamily(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/product",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         						
         						for (var i = 0; i<response.length; i++) 
         						{
         						var content = content + '<option value="'+response[i].id_part+'">'+ response[i].reference +'</option>';
         						}
         						document.getElementById("productContent").innerHTML = content;
         					}
         	});
         });
         
         $(function getSites(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/sites",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         					
         						for (var i = 0; i<response.length; i++) 
         						{
         						var content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						
         						}
         						document.getElementById("SitesContent").innerHTML = content;
         					}
         	});
         });
         	
         $(function getKinds(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/kinds",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         					
         						for (var i = 0; i<response.length; i++) 
         						{
         						var content = content + '<option value="'+response[i].id_kind+'">'+ response[i].kind +'</option>';
         						
         						}
         						document.getElementById("KindsContent").innerHTML = content;
         					}
         	});
         });
         
         		$(function getMeasurement(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/measurements",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         					
         						for (var i = 0; i<response.length; i++) 
         						{
         						var content = content + '<option value="'+response[i].id_measurement+'">'+ response[i].measurement +'</option>';
         						
         						}
         						document.getElementById("measurementContent").innerHTML = content;
         					}
         	});
         });
         	
         									function addinstock() {
         									
         									
         									var quanty = document.getElementById("quanty").value;
         									var driveway = document.getElementById("driveway").value;
         									var bay = document.getElementById("bay").value;
         									var position = document.getElementById("position").value;
         									var rack = document.getElementById("rack").value;
         									var locker = document.getElementById("locker").value;
         									var id_typestock = document.getElementById("KindsContent").value;
         									var id_part = document.getElementById("productContent").value;
         									var id_site = document.getElementById("SitesContent").value;
         									var id_measurement = document.getElementById("id_measurement").value;
         									
         									$.ajax({
         									
         										type: 		"GET",
         										url:		"http://www.think-parc.com/webservice/v1/companies/stocks/addinstock/quanty/"+quanty+"/id_measurement/"+id_measurement+"/driveway/"+driveway+"/bay/"+bay+"/position/"+position+"/locker/"+locker+"/rack/"+rack+"/id_site/"+id_site+"/id_typestock/"+id_typestock+"/id_part/"+id_part,  
         										success:	function(data) {
         														$(document).ready(function() {
         															$.toast({heading: "Success",text: "Product successfully added.", icon: "success"});
         														});
         														
         													},
         										error:		function(xhr, status, error) {
         														$(document).ready(function() {
         															$.toast({heading: "Error",text: "Error", icon: "error"});
         														});
         													}
         											});
         											
         										};
         								
      </script>
   </head>
   <body>
      <?php 
	  include('../header/navbar.php');
         ?>
      <img src="../../images/zoom-bg-5.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners"/>
      <center>
         <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad" >
            <div class="templatemo-content">
               <div class="black-bg btn-menu margin-bottom-20">
                  <h2>Fiche produit</h2>
                  <div class="panel-body">
                     <div class="row">
                        <div class=" col-md-9 col-lg-11 ">
                           <form class="formimg" action="javascript:addinstock();" method="post" enctype="multipart/form-data">
                              <table class="table table-user-information">
                                 <tbody>
                                    <tr>
                                       <td><b>Produits</b></td>
                                       <td class="infos">
                                          <select id="productContent" class="medium">
                                             <!-- Here are loaded product content -->
                                          </select>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><b>Quantit&eacute;e</b></td>
                                       <td>
                                          <input type="text" id="quanty" class="small" placeholder="quantité"/>
                                          <select id="measurementContent" class="medium">
                                             <!-- Here are loaded measurementContent  -->
                                          </select>
                                          <a href="stockmultisite.php" target="_blank"><i>voir le stock multi site</i></a>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><b>Emplacements</b></td>
                                       <td>
                                          <input type="text" id="id_measurement" class="large" placeholder="Magasin No"/>&nbsp;
                                          <input type="text" id="driveway" class="large" placeholder="Allee"/>&nbsp;
                                          <input type="text" id="bay" class="large" placeholder="Travee"/>&nbsp;
                                          <input type="text" id="rack" class="large" placeholder="Etage"/>&nbsp;
                                          <input type="text" id="locker" class="large" placeholder="Casier"/>&nbsp;
                                          <input type="text" id="position" class="large" placeholder="Position"/>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><b>Equivalence</b></td>
                                       <td>
                                          <input type="text" id="equivalence" class="large" placeholder="facultatif"/>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><b>Type stock</b></td>
                                       <td>
                                          <select id="KindsContent" class="medium"/>
                                          </select>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><b>Affectation</b></td>
                                       <td>
                                          <select id="SitesContent" class="medium"/>
                                          </select>
                                       </td>
                                    </tr>
                                    </tr>
                                    </tr>
                                    <tr>
                                       <td></td>
                                       <td>
                                          <input type="submit" value="Valider" class="btn btn-success">&nbsp;<input type="reset" value="Reinitialiser" class="btn btn-warning"/>
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
      </center>
   </body>
</html>