/**
 * addinstock.js
 *
 * @see addinstock.php
 * @author Said KHALID
 * @version 1.0
 */

var idpart = "";
				
	  
	   function checkref(ref){
				
				var div = document.getElementById("textDiv");
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				ref = document.form1.ref.value;
				
					if (ref == "")
					 {
						div.textContent = "";
			     	 }
								
				
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/checkref/"+ref+"/company/"+id_company,  
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var verif = false;
						        
         						for (var i = 0; i<response.length; i++) 
         						{
									if (ref.toUpperCase() == response[i].reference.toUpperCase())
										{
											verif=true;
											idpart = response[i].id_part;
										}
         						}
   							
								if (verif)
								{
									div.textContent = "  <?php echo $stocks['EXIST'];?>";
									div.className='green';
								} else {
									div.className='red';
									div.textContent = "  <?php echo $stocks['NOTEXIST'];?>";
									idpart = "";
								}
							
							}
			});
         };
	  

        $(function getSites(id_company){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/sites", 
         		success:	function(data) {
         						var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['SITE'];?></option>';
         					
         						for (var i = 0; i<response.length; i++) 
         						{
									 content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
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
								var content = '<option selected disabled><?php echo $stocks['KINDS'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									 content = content + '<option value="'+response[i].id_kind+'">'+ response[i].kind +'</option>';
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
								var content = '<option selected disabled><?php echo $stocks['MEASURE'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_measurement+'">'+ response[i].measurement +'</option>';
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
         	var id_site = document.getElementById("SitesContent").value;
         	var id_measurement = document.getElementById("measurementContent").value;
			var storehouse = document.getElementById("storehouse").value;
			
			if (storehouse.length == 0)
			{
				storehouse = "Aucun";
			}
         									
         		$.ajax({
         									
         			type: 		"POST",
         			url:		"http://www.think-parc.com/webservice/v1/companies/stocks/addinstock/quanty/"+quanty+"/id_measurement/"+id_measurement+"/driveway/"+driveway+"/bay/"+bay+"/position/"+position+"/locker/"+locker+"/rack/"+rack+"/id_site/"+id_site+"/id_typestock/"+id_typestock+"/id_part/"+window.idpart+"/storehouse/"+storehouse,  
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