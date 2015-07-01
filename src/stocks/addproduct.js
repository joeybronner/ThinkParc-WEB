/**
 * addproduct.js
 *
 * @see addproduct.php
 * @author Said KHALID
 * @version 1.0
 */

$(function onLoad() 
			{
				getFamily();
				document.getElementById("underfamilyContent").style.display = "none";
				document.getElementById("underfamilyContent2").style.display = "none";
				
			});
			
		 function OnResetClick()
		 {
				
				document.getElementById("underfamilyContent").style.display = "none";
				document.getElementById("underfamilyContent2").style.display = "none";
				getFamily();
		 }
		
         function getFamily(){
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/family",  
         		success:	function(data) {
         						var response = JSON.parse(data);
         						var content = '<option selected disabled><?php echo $stocks['FAMILY'];?></option>';
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_family+'">'+ response[i].family +'</option>';
         						}
								 document.getElementById("familyContent").innerHTML = content;
         					}
         	});
         };
         		function getUnderFamily(id_family){
				
				document.getElementById("underfamilyContent").style.display = "block";
				
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/underfamily/"+id_family,  
         		success:	function(data) {
         						var response = JSON.parse(data);
         						var content = '<option selected disabled><?php echo $stocks['UNDERFAMILY'];?></option>';

         						for (var i = 0; i<response.length; i++) 
         						{
         						  content = content + '<option value="'+response[i].id_family+'">'+ response[i].family +'</option>';
         						}
         						document.getElementById("underfamilyContent").innerHTML = content;
								document.getElementById("underfamilyContent").disabled = false;

         					}
         	});
         };
         
		 function getUnderFamily2(id_family){
				
				document.getElementById("underfamilyContent2").style.display = "block";
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/underfamily/"+id_family,  
         		success:	function(data) {
         						var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['UNDERFAMILY2'];?></option>';
         						for (var i = 0; i<response.length; i++) 
         						{
         						   content = content + '<option value="'+response[i].id_family+'">'+ response[i].family +'</option>';
         						}
         						document.getElementById("underfamilyContent2").innerHTML = content;
								document.getElementById("underfamilyContent").disabled = false;
         					}
         	});
         };
    
    
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
			 var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
			 var family = document.getElementById("familyContent");
			 var id_family2 = document.getElementById("underfamilyContent");
			 var id_family3 = document.getElementById("underfamilyContent2");
			 var id_currency = document.getElementById("CurrenciesContent").value;
			 var brand = document.getElementById("brand").value;
			 var comment = document.getElementById("com").value;
			 
			 if (brand.length == 0)
			 {
				brand = "Aucune marque";
			 }
			 
			 if (comment.length == 0)
			 {
				comment = "Aucun commentaire";
			 }
			 
			 
			 if (family.selectedIndex  == 0 )
			  {
				 $.toast({
							  heading: "Error",
							  text: "An error occured, a value is required for all fields. Please check your entries and try again.",
							  icon: "error"
							});
				 return 0;
			  }
			  
			  
			  if (family.selectedIndex  > 0 )
			  {
				 var id_family = document.getElementById("familyContent").value;
			  }
					
				
			  if (id_family2.selectedIndex > 0 )
					 {
						var id_family = document.getElementById("underfamilyContent").value;
					 } 
					  
			  if (id_family3.selectedIndex > 0)
				{
				
					var id_family = document.getElementById("underfamilyContent2").value;
				}
			
			   
         							
         									
         $.ajax({
         									
         	type: 		"POST",
         	url:		"http://www.think-parc.com/webservice/v1/companies/stocks/addProduct/reference/"+reference+"/designation/"+designation+"/buyingprice/"+buyingprice+"/id_currency/"+id_currency+"/id_company/"+id_company+"/id_family/"+id_family+"/brand/"+brand+"/comment/"+comment,  
         	success:	function(data) {
         	$(document).ready(function() {
         		$.toast({heading: "Success",text: "Product successfully added.", icon: "success"});
         		});
         														
					},
         			 error: function(xhr, status, error) {
						  $(document).ready(function() {
							$.toast({
							  heading: "Error",
							  text: "An error occured, a value is required for all fields. Please check your entries and try again.",
							  icon: "error"
							});
						  });
						}
         		});
         											
         	};
			
	 /** End of file */