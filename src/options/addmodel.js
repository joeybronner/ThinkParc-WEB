/**
 * addbrand.js
 *
 * @see addbrand.php
 * @author Said KHALID
 * @version 1.0
 */
 


/** Method called on page loading */

$(function onLoad() 
{
	getbrand();
	document.getElementById("model").style.display = "none";
});	
	

/** Allows to add a new model for one brand */	
function addmodel(id_brand, model) {
         									
	var id_brand = document.getElementById("id_brand").value;
	 var model = document.getElementById("model").value;
					
         									
  $.ajax({
         									
   type: 		"POST",
   url:		"http://www.think-parc.com/webservice/v1/companies/options/addmodel/"+model+"/idbrand/"+id_brand,  
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
			
			
         	
/** Allows to get all brands on a list */	
 function getbrand(){
				
	$.ajax({
    method: 	"GET",
    url:		"http://think-parc.com/webservice/v1/companies/options/allbrands",  
    success:	function(data) {
         		
				var response = JSON.parse(data);
				var content = '<option selected disabled><?php echo $options['BRAND'];?></option>';
         		for (var i = 0; i<response.length; i++) 
         			{
         			  content = content + '<option value="'+response[i].id_brand+'">'+ response[i].brand +'</option>';
         			}
         				
					document.getElementById("id_brand").innerHTML = content;
							
         				}
					});
			};
			
			
/** Allows to display a hidden div */				
function displayinput()
{			
document.getElementById("model").style.display = "block";       
};
    	
 /** End of file */