<?php
      	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/stocks/reception.fr.php');
	else
		include('../../lang/stocks/reception.en.php');
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
		var title = [];
		var type = [];
		var thereceiver = [];
		
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
								var content = '<option selected disabled><?php echo $stocks['LIST'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].title+'"> date : '+ response[i].transferdate +' --- libellé : '+ response[i].title +' </option>';
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
		
		 function hideblock() 
			{		
				document.getElementById("transferblock").style.display = "none";
				gettransferlist(id_company);
			};
			
			
		function receptioncheck()
			{
			
				var thesize = window.size;
				var exec;
				var id_company = <?php echo $_SESSION['fct_id_company']; ?>;
				total = 0;
				
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
						var thereceiver = window.thereceiver[i];
						var measure = window.measure[i];
						var title = window.title[i];

						
						if (driveway != '' && locker!= '' && rack!= '' && position!= '' && bay!= '' && thereceiver!='' && idpart!='' && idtrans!='' && myquanty!='')
						{
							total++;
							TransfertProductInStock(idtrans, idpart, driveway, bay, position, rack, locker, myquanty, thereceiver, type, measure);
							exec = true;
							hideblock();
						} else
						{
						    exec =false;
						}
							
				}
				
					total = 0;
					
					if (!exec)
					{
						$.toast({heading: "Error",text: "Error", icon: "error"});
					}
					
					
			}
			
		function isInt(value) 
		{
			return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
		}
			
			
		function TransfertProductInStock(idtrans, idpart, driveway, bay, position, rack, locker, myquanty, thereceiver, type, measure)
		 {
		 
				
				$.ajax({
					method: 	"POST",
					url:		"http://think-parc.com/webservice/v1/companies/stocks/idtransfert/"+idtrans+"/quanty/"+myquanty+"/idpart/"+idpart+"/driveway/"+driveway+"/bay/"+bay+"/position/"+position+"/rack/"+rack+"/locker/"+locker+"/receiver/"+thereceiver+"/type/"+type+"/measure/"+measure,   
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
								var content = '<option selected disabled><?php echo $stocks['SELECTSITE'];?></option>';
								
         						for (var i = 0; i<response.length; i++) 
         						{
									content = content + '<option value="'+response[i].id_site+'">'+ response[i].name +'</option>';
         						}
         						
								document.getElementById("idsite").innerHTML = content;
								
         					}
         	});
         };
		 	
		
		function getalltransferts(id_company, title)
		 {
		 
			getblock();
			getsitecompany(id_company);
			
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/stocks/getalltransferts/company/"+id_company+"/title/"+title, 
			success:	function(data) {
							
							var response = JSON.parse(data);
							var dataSet = new Array(response.length);
							idtransfert = new Array(response.length);
							idpart = new Array(response.length);
							myquanty = new Array(response.length);
							type = new Array(response.length);
							measure = new Array(response.length);
							title = new Array(response.length);
							thereceiver = new Array(response.length);
							
								for (var i = 0; i<response.length; i++) 
							{	
									
									dataSet[i] = new Array(	response[i].title,   
														response[i].quantity,
														response[i].reference,
														response[i].transferdate,
														response[i].receivername,
														'<input type="text" id="driveway'+i+'" class="small"></input>',
														'<input type="text" id="bay'+i+'" class="small"></input>',
														'<input type="text" id="position'+i+'" class="small"></input>',
														'<input type="text" id="rack'+i+'" class="small"></input>',
														'<input type="text" id="locker'+i+'" class="small"></input>');
														
										
							size = i;
							idtransfert[i] = response[i].id_transfert;
							idpart[i] = response[i].id_part;
							myquanty[i] = response[i].quantity;
							type[i] = response[i].typestock;
							measure[i] = response[i].measurement;
							title[i] = response[i].title;
							thereceiver[i] = response[i].receiver;
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
									{ "title": "<?php echo $stocks['LABEL'];?>" , "class": "center fctbw" },
									{ "title": "<?php echo $stocks['QUANTY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['REFERENCE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['DATE'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['RECIPIENT'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['BAY'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['POSITION'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['RACK'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['LOCKER'];?>", "class": "center fctbw" },
									{ "title": "<?php echo $stocks['DRIVE'];?>", "class": "center fctbw" }
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
		
		<img src="../../images/zoom-bg-4.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners"/>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php?section=products">
					<h5><i class="fa fa-chevron-left"></i><?php echo $stocks['BACK'];?></h5>
				</a>
			</div>
		 </div> 
		   <div class="templatemo-content">
				<div class="black-bg btn-menu margin-bottom-20">
					<h2><?php echo $stocks['TITLE'];?></h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<table class="table-no-border">
										<tr>
											<td><h5><?php echo $stocks['SELECTTRANSFER'];?></h5></td>
										</tr>
										<tr>
											<td>
												<select id="transfertlist" class="form-control" onchange="getalltransferts(id_company, this.value);">
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
					<h2><?php echo $stocks['TABLETITLE'];?></h2>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12"> 
								<form>
									<div class="col-md-12 col-lg-12">
										<div id="transfert">
									    </div>	
										<a href="javascript:receptioncheck();" class="btn btn-success"><?php echo $stocks['RECEIVE'];?></a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('../footer/footer.php'); ?>
 </body>
</html>