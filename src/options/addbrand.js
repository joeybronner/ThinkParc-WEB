/**
 * addbrand.js
 *
 * @see addbrand.php
 * @author Said KHALID
 * @version 1.0
 */
 
 
 /** Allows to add a new brand */
 
 function addbrand(brand) {
         									
var brand = document.getElementById("brand").value;
					
         									
$.ajax({
         									
 type: 		"POST",
 url:		"http://www.think-parc.com/webservice/v1/companies/options/addbrand/"+brand,  
 success:	function(data) {
         	$(document).ready(function() {
         		$.toast({heading: "Success",text: "Brand successfully added.", icon: "success"});
         		});
         														
					},
         			error:		function(xhr, status, error) {
         			$(document).ready(function() {
         				$.toast({heading: "Error",text: "Error", icon: "error"});
         					});
         						}
         		});
         											
      };

 /** End of file */