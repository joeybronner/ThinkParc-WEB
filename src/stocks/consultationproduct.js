/**
 * consultationproduct.js
 *
 * @see consultationproduct.php
 * @author Said KHALID
 * @version 1.0
 */


$(function onLoad() {
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				document.getElementById("productblock").style.display = "none";
				getSites(id_company);
			});
			
		
			
			function getSites(id_company){
		 
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/"+id_company+"/sites", 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled><?php echo $stocks['SITELIST'];?></option>';
								content = content + '<option value="0"><?php echo $stocks['ALLSITES'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						
								document.getElementById("listproducts").innerHTML = content;
         					}
         	});
         };
			
			
			function getsiteproduct(id_site, id_company) {
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/siteproduct/"+id_site+"/company/"+id_company, 
			success:	function(data) {
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							
							for (var i = 0; i<response.length; i++) 
							{
							
								if ( response[i].quanty == 0 )
									{
										var quanty = "Rupture de stock";
									} else {
									
										var quanty = response[i].quanty + " " + response[i].measurement + "(s)";
									}
								
									 if(typeof response[i].brand == '' && response[i].brand == 0)
									 //if (response[i].brand.length == 0)
									 {
										response[i].brand = "Aucune marque";
									 }
									 if(typeof response[i].comment == '' && response[i].comment == 0)
									 //if (response[i].comment.length == 0)
									 {
										response[i].comment = "Aucun commentaire";
									 }
									 
									 if(typeof response[i].storehouse == '' && response[i].storehouse == 0)
									  //if (response[i].storehouse.length == 0)
									 {
										response[i].storehouse = "Aucun";
									 }
									
								dataSet[i] = new Array(	response[i].reference, 
														response[i].designation, 
														response[i].buyingprice + response[i].currency, 
														response[i].company,
														response[i].family,
														quanty,
														response[i].driveway,
														response[i].bay,
														response[i].position,
														response[i].rack,
														response[i].site,
														response[i].typestock,
														response[i].locker,
														response[i].brand,
														response[i].comment,
														response[i].storehouse,
														'<a href="javascript:deletefromstock(' + response[i].id_stock + ');"><i id="icon_remove" class="fa fa-times"></i></a>');
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
									{ "title": "<?php echo $stocks['REFERENCE'];?>" , "class": "center fctbw"},
									{ "title": "<?php echo $stocks['DES'];?>" , "class": "center fctbw"},
									{ "title": "<?php echo $stocks['PRICE'];?>" , "class": "center fctbw" },
									{ "title": "<?php echo $stocks['COMP'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['FAM'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['QUANTY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['BAY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['DRIVE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['POS'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['RACK'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['SITE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['TYPE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['LOCKER'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['BRAND'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['COM'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['STOREHOUSE'];?>", "class": "center fctbw" },
									{ "title": "", "class": "center fctbw" }
								]
							} );   
						},
			error:		function(data) {
							
						}
		});
	};	 
			
				function deletefromstock(id_stock) {
				  $.ajax({
					method: "DELETE",
					url: "http://think-parc.com/webservice/v1/companies/stocks/deletefromstock/id_stock/" + id_stock,
					success: function(data) {
					  $(document).ready(function() {
						//$.toast({heading: "Success",text: "Product successfully removed.", icon: "success"});
						alert("Suppression réussi");
						id_site = document.getElementById('listproducts').value;
						id_company = <?php echo $_SESSION['fct_id_company']; ?>;
						getsiteproduct(id_site, id_company);
						//$('#example').DataTable().ajax.reload();
					  });
					},
					error:	function() 
							{
								//$.toast({heading: "Error",text: "Error", icon: "error"});
								alert("Erreur");
							}	
				  });
				}
				
	 /** End of file */