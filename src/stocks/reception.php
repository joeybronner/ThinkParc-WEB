<?php
   session_start();
?>
<html>
	<head>
		<title>FCT Partners</title>
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
		<meta name="description" content="">
		<meta charset="utf-8">
		<link rel="stylesheet" href="../../css/bootstrap.css">
		<link rel="stylesheet" href="../../css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/templatemo_main.css">
		<link rel="stylesheet" href="../../css/app.css">
		<link rel="stylesheet" href="../../css/toast/jquery.toast.css">
		<link rel="stylesheet" href="../../css/DataTable/jquery.dataTables_themefct.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/jquery-ui.min.js"></script>
		<script src="../../js/jquery.backstretch.min.js"></script>
		<script src="../../js/templatemo_script.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script type="text/javascript" src="../../js/jquery.toast.js"></script>
		<script type="text/javascript" src="../../js/jquery.dataTables.js"></script>  
		<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>	
		
		<script>
	
		var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		var size;
		var myquanty = [];
		var idtransfert = [];
		var idpart = [];
		var measure = [];
		var type = [];
		
		$(function onLoad() 
		{
			var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
			gettransferlist(id_company);
			document.getElementById("transferblock").style.display = "none";
		});
		
		function gettransferlist(id_company) 
			{
				

				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/gettransferlist/company/"+id_company, 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled>Receptions en attentes</option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_transfert+'">Identifiant du transfert : '+response[i].id_transfert +' --- date : '+ response[i].transferdate +' </option>';
         						}
         						
								document.getElementById("transfertlist").innerHTML = content;
								
         					}
         	});
         };
		 
		 function getblock() 
			{		
				document.getElementById("transferblock").style.display = "block";
				getsitecompany(id_company);
			};
			
			
		function receptioncheck()
			{
			
				var thesize = window.size;
				var exec;
				//var productnumber;
				var idsite = document.getElementById('idsite').value;
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				total = 0;
				// indice commencant par 0
				for (var i = 0; i <= thesize; i++ )
				{
						
						var driveway = document.getElementById('driveway'+i).value;
						var locker = document.getElementById('locker'+i).value;
						var rack = document.getElementById('rack'+i).value;
						var position = document.getElementById('position'+i).value;
						var bay = document.getElementById('bay'+i).value;
						var idtrans = window.idtransfert[i];
						var idpart = window.idpart[i];
						var myquanty = window.myquanty[i];
						var type = window.type[i];
						var measure = window.measure[i];

						
						if (driveway != '' && locker!= '' && rack!= '' && position!= '' && bay!= '' && idsite!='' && idpart!='' && idtrans!='' && myquanty!='')
						{
							total++;
							TransfertProductInStock(idtrans, idpart, driveway, bay, position, rack, locker, myquanty, idsite, type, measure);
							exec = true;
						} else
						{
						  exec =false;
						}
							
				}
				
					total = 0;
					
					if (exec)
					{
						gettransferlist(id_company);
					} else
					{
						$.toast({heading: "Error",text: "Error", icon: "error"});
					}
					getalltransferts(id_company);
			
			}
			
		function isInt(value) 
		{
			return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
		}
			
			
		function TransfertProductInStock(idtrans, idpart, driveway, bay, position, rack, locker, myquanty, idsite, type, measure)
		 {
		 
				/*var driveway = document.getElementById('driveway'+i).value;
				var locker = document.getElementById('locker'+i).value;
				var rack = document.getElementById('rack'+i).value;
				var position = document.getElementById('position'+i).value;
				var bay = document.getElementById('bay'+i).value;
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		

				if (!isInt(quantity))
				{
					alert('Veuillez ne saisir que des entiers');
					gettransferlist(id_company);
					return false;
				}*/
				
				var idsite = document.getElementById('idsite').value;
				
				
				$.ajax({
					method: 	"POST",
					url:		"http://think-parc.com/webservice/v1/companies/stocks/idtransfert/"+idtrans+"/quanty/"+myquanty+"/idpart/"+idpart+"/driveway/"+driveway+"/bay/"+bay+"/position/"+position+"/rack/"+rack+"/locker/"+locker+"/idsite/"+idsite+"/type/"+type+"/measure/"+measure,   
					success:	function() 
								{
									$.toast({heading: "Success",text: "Product(s) successfully transfered in stock.", icon: "success"});
									gettransferlist(id_company);
								},
					error:		function() 
								{
									$.toast({heading: "Error",text: "Error", icon: "error"});
								}	
			});
		
		 }	
		 
		
			function getsitecompany(id_company) 
			{
				

				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
		 
            	$.ajax({
         		method: 	"GET",
         		url:		"http://think-parc.com/webservice/v1/companies/stocks/sitecompany/"+id_company, 
         		success:	function(data) {
         						
								var response = JSON.parse(data);
								var content = '<option selected disabled>Choisir un site</option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						
								document.getElementById("idsite").innerHTML = content;
								
         					}
         	});
         };
		 	
		 
		 
			
		
		function getalltransferts(id_company)
		 {
		 
			getblock();
			getsitecompany(id_company);
			
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/getalltransferts/company/"+id_company, 
			success:	function(data) {
							
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							idtransfert = new Array(response.length);
							idpart = new Array(response.length);
							myquanty = new Array(response.length);
							type = new Array(response.length);
							measure = new Array(response.length);
							
								for (var i = 0; i<response.length; i++) 
							{	
									
									dataSet[i] = new Array(	response[i].id_transfert,   
														response[i].quantity,
														response[i].reference,
														response[i].transferdate,
														'<input type="text" id="driveway'+i+'" class="small"></input>',
														'<input type="text" id="bay'+i+'" class="small"></input>',
														'<input type="text" id="position'+i+'" class="small"></input>',
														'<input type="text" id="rack'+i+'" class="small"></input>',
														'<input type="text" id="locker'+i+'" class="small"></input>',
														'<select id="idsite"/>');
														
										
							size = i;
							idtransfert[i] = response[i].id_transfert;
							idpart[i] = response[i].id_part;
							myquanty[i] = response[i].quantity;
							type[i] = response[i].typestock;
							measure[i] = response[i].measurement;
							}
							
							
							$('#transfert').html( '<table  cellspacing="0" width="100%" id="example"></table>' );
							
							var table = $('#example').dataTable( {
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
									{ "title": "Id" , "class": "center fctbw" },
									{ "title": "Qté", "class": "center fctbw" },
									{ "title": "Ref", "class": "center fctbw" },
									{ "title": "Date du transfert", "class": "center fctbw" },
									{ "title": "Travée", "class": "center fctbw" },
									{ "title": "Position", "class": "center fctbw" },
									{ "title": "Etagère", "class": "center fctbw" },
									{ "title": "Casier", "class": "center fctbw" },
									{ "title": "Allée", "class": "center fctbw" }, 
									{ "title": "Site", "class": "center fctbw" }
								]
							} );   
						},
			error:		function(data) {
							//alert('error');
						}
		});
	};	 
		
		
		</script>
		
		
		</head>
		<body>
		<?php include('../header/navbar.php'); ?>
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Choix de la récéption</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<table class="table-no-border">
										<tr>
											<td><h5>Sélectionner le transfert</h5></td>
										</tr>
										<tr>
											<td>
												
												<select id="transfertlist" class="form-control" onchange="getalltransferts(id_company);">
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
				
	<div id="transferblock">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 toppad">
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2>Reception en attentes</h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12">
										<div id="transfert">
									    </div>	
										<a href="javascript:receptioncheck();" class="btn btn-success">Récéptionner</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 </body>
</html>