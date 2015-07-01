/**
 * history.js
 *
 * @see history.php
 * @author Said KHALID
 * @version 1.0
 */

$(function onLoad() {
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				document.getElementById("productblock").style.display = "none";
				getreleaseproduct(id_company);
			});
			
			
			function getreleaseproduct(id_company){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/release", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['OUTPUTS'];?></option>';
								content = content + '<option value="all"><?php echo $stocks['ALLOUTPUTS'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].title+'"> date : '+ response[i].transferdate +' --- <?php echo $stocks['WORDING'];?> : '+ response[i].title +' </option>';
         						}
         						
								document.getElementById("list").innerHTML = content;
         					}
         	});
         };
			
			
			function gethistory(title, id_company) {
			
			var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
			
			$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/historylist/"+title+"/company/"+id_company, 
			success:	function(data) {
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							
							for (var i = 0; i<response.length; i++) 
							{
							
									
								dataSet[i] = new Array( response[i].title,  
														response[i].reference,
														response[i].companyname,
														response[i].quantity,
														response[i].transferdate,
														response[i].validationdate);
							}
						
							document.getElementById("productblock").style.display = "block";
							
							$('#stock').html( '<table cellspacing="0" width="100%" id="example"></table>' );
							
							$('#example').dataTable( {
								"data": dataSet,
								   "scrollX": true,
								   "bPaginate": true,
								   "bLengthChange": true,
								   "bStateSave": true,
								   "bFilter": true,
								   "bSort": true,
								   "bInfo": true,
								   "bAutoWidth": true,
								"columns": [
									{ "title": "<?php echo $stocks['WORDING'];?>" , "class": "center fctbw"},
									{ "title": "<?php echo $stocks['PRODUCT'];?>" , "class": "center fctbw" },
									{ "title": "<?php echo $stocks['RECIPIENT'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['QUANTITY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['TRANSFERTDATE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['VALIDATIONDATE'];?>", "class": "center fctbw" }
								]
							} );   
						},
			error:		function(data) {
							
						}
		});
	};	 
	
 /** End of file */