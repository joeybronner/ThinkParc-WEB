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
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/family",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         						
         						for (var i = 0; i<response.length; i++) 
         						{
         						var content = content + '<option value="'+response[i].id_family+'">'+ response[i].family +'</option>';
         						}
         						document.getElementById("familyContent").innerHTML = content;
         					}
         	});
         });
         		$(function getUnderFamily(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/underfamily",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         						
         						for (var i = 0; i<response.length; i++) 
         						{
         						var content = content + '<option value="'+response[i].id_family+'">'+ response[i].family +'</option>';
         						
         						}
         						document.getElementById("underfamilyContent").innerHTML = content;
         					}
         	});
         });
         $(function getUnderFamily2(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/underfamily2",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         				
         						for (var i = 0; i<response.length; i++) 
         						{
         						var content = content + '<option value="'+response[i].id_family+'">'+ response[i].family +'</option>';
         						
         						}
         						document.getElementById("underfamilyContent2").innerHTML = content;
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
         $(function getCurrencies(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/currencies",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         					
         						for (var i = 0; i<response.length; i++) 
         						{
         						var content = content + '<option value="'+response[i].id_currency+'">'+ response[i].symbol +'</option>';
         						
         						}
         						document.getElementById("CurrenciesContent").innerHTML = content;
         					}
         	});
         });
         			
         									function addProduct() {
         									
         									var reference = document.getElementById("reference").value;
         									var designation = document.getElementById("designation").value;
         									var buyingprice = document.getElementById("buyingprice").value;
         									var id_company = document.getElementById("SitesContent").value;
         									var id_currency = document.getElementById("CurrenciesContent").value;
         									var id_family = document.getElementById("familyContent").value;
         							
         									
         									$.ajax({
         									
         										type: 		"GET",
         										url:		"http://www.think-parc.com/webservice/v1/companies/stocks/addProduct/reference/"+reference+"/designation/"+designation+"/buyingprice/"+buyingprice+"/id_currency/"+id_currency+"/id_company/"+id_company+"/id_family/"+id_family,  
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
                           <form class="formimg" action="javascript:addProduct();" method="post" enctype="multipart/form-data">
                              <table class="table table-user-information">
                                 <tbody>
                                    <tr>
                                       <td><b>Familles</b></td>
                                       <td class="infos">
                                          <select id="familyContent" class="medium">
                                             <!-- Here are loaded Family content -->
                                          </select>
                                          <select id="underfamilyContent" class="medium">
                                             <!-- Here are loaded Under Family content -->
                                          </select>
                                          <select id="underfamilyContent2" class="medium">
                                          </select>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><b>R&eacute;f&eacute;rence constructeur</b></td>
                                       <td><input type="text" id="reference"/></td>
                                    </tr>
                                    <tr>
                                       <td><b>D&eacute;signation de la pi&egrave;ce</b></td>
                                       <td><input type="text" id="designation"/></td>
                                    </tr>
                                    <tr>
                                       <td><b>Type de pi&egrave;ce</b></td>
                                       <td>
                                          <select id="KindsContent" class="medium"/>
                                          </select>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><b>Prix d'achat</b></td>
                                       <td>
                                          <input type="text" id="buyingprice" class="small"/>
                                          <select id="CurrenciesContent">
                                          </select>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><b>Affectation</b></td>
                                       <td>
                                          <select id="SitesContent">
                                          </select>
                                       </td>
                                    </tr>
                                    </tr>
                                    </tr>
                                    <tr>
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