<?php
	if(!isset($_SESSION)) {
		session_start();
	}
	include('../../db/check_session.php');
	if($_SESSION['fct_lang'] == 'FR')
		include('../../lang/documents/documents.fr.php');
	else
		include('../../lang/documents/documents.en.php');
?>
<html>
<head>
	<title><?php echo $documents['TITLE_DOCUMENTS'];?></title>
	<meta charset="UTF-8">
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
	<script type="text/javascript" src="../../js/spin.js"></script>
	<script>
	$(function onLoad() {
		// Hide some divs
		document.getElementById("file-form").style.display = "none";
		
		// Load files
		getFiles();
	});
	function removeFile(id_file) {
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/files/" + id_file + "/path",  
			success:	function(data) {
							var response = JSON.parse(data);
							var path = response[0].path;
							var formData = new FormData();
							formData.append('path', path);
							var xhr = new XMLHttpRequest();
							xhr.open('POST', '../../files/removefile.php?target=global_company', true);
							xhr.onload = function () {
								if (xhr.readyState == 4) {
									if (xhr.status == 200) {
										$.ajax({
											method: 	"DELETE",
											url:		"http://think-parc.com/webservice/v1/files/" + id_file,  
											success:	function(data) {
															var response = JSON.parse(data);
															getFiles();
															$.toast({heading: "Success",text: "File successfully removed.", icon: "success"});
														}
										});
										
									} else {
										$.toast({heading: "Error",text: "", icon: "error"});
									}	
								} 
							};
							xhr.send(formData);
						}
		});
	}
	function downloadFile(id_file) {
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/files/" + id_file + "/path",  
			success:	function(data) {
							var response = JSON.parse(data);
								window.open('../../files/global_company/' + response[0].path);	
						}
		});
	}
	function getFiles() {
		getCompany(function(company){
			$.ajax({
				method: 	"GET",
				url:		"http://think-parc.com/webservice/v1/companies/" + company + "/files",
				success:	function(data) {
								var response = JSON.parse(data);
								var dataSet = new Array(response.length);
								for (var i = 0; i<response.length; i++) {
									var ext = "." + response[i].path.substr(response[i].path.lastIndexOf('.') + 1);
									var logo = "fa fa-file-o";
									if (ext == ".xls" || ext == ".xlsx") {
										logo = "fa fa-file-excel-o";
									} else if (ext == ".pdf") {
										logo = "fa fa-file-pdf-o";
									} else if (ext == ".png" || ext == ".jpg" || ext == ".jpeg") {
										logo = "fa fa-file-image-o";
									} else if (ext == ".doc" || ext == ".docx") {
										logo = "fa fa-file-word-o";
									}
									
									dataSet[i] = new Array(	response[i].date_upload,
															'<i class="' + logo + '"></i>', 
															response[i].path, 
															'<a href="javascript:removeFile(' + response[i].id_file + ');"><i class="fa fa-times"></i></a>',
															'<a href="javascript:downloadFile(' + response[i].id_file + ');"><i class="fa fa-download"></i></a>');
								}
								
								$('#documents').html( '<table class="display" id="listoffiles"></table>' );
					
								$('#listoffiles').dataTable( {
									"data": dataSet,
									"scrollX": true,
									"bPaginate": true,
									"aLengthMenu": [
										[25, 50, 100, 200, -1],
										[25, 50, 100, 200, "All"]
									],
									"bLengthChange": true,
									"bStateSave": true,
									"bFilter": true,
									"bSort": true,
									"bInfo": true,
									"bAutoWidth": true,
									"columns": [
										{ "title": "Date" , "class": "center fctbw"},
										{ "title": "Type" , "class": "center fctbw"},
										{ "title": "Fichier" , "class": "center fctbw"},
										{ "title": "", "class": "center fctbw"},
										{ "title": "", "class": "center fctbw"}
									]
								} );
							}
			});				
		});
	}
	function getCompany(handleData){
		var id_user = <?php echo $_SESSION['fct_id_user']; ?>;
		$.ajax({
			method: 	"GET",
			url:		"http://think-parc.com/webservice/v1/companies/users/" + id_user,  
			success:	function(data) {
							var response = JSON.parse(data);
							handleData(response[0].id_company);
						}
		});
	};
	function uploadFile() {
		startSpinner();
		var file = document.getElementById('file-select').files[0];
		var formData = new FormData();

		// Check the file type.
		var fakepath = document.getElementById("file-select").value;
		var ext = "." + fakepath.substr(fakepath.lastIndexOf('.') + 1);
		if (!file.type.match('.pdf') && 
			!file.type.match('.doc') &&
			!file.type.match('.docx') &&
			!file.type.match('.png') &&
			!file.type.match('.xls') &&
			!file.type.match('.xlsx') &&
			!file.type.match('.ppt') &&
			!file.type.match('.pptx') &&
			!file.type.match('.jpg') &&
			!file.type.match('.jpeg')) {
				$(document).ready(function() {
					$.toast({heading: "Error",text: "Only Excel, Powerpoint, Pictures, PDF and Documents are supported.", icon: "error"});
				});
		} else {
			// Add file to data form
			var d = new Date();
			var generatedfilename = d.getTime() + "_" + file.name;
			formData.append('myfiles', file, generatedfilename);
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '../../files/uploadfile.php?target=global_company', true);
			xhr.onload = function () {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						$(document).ready(function() {
							getCompany(function(company){
								$.ajax({
									method: 	"POST",
									url:		"http://think-parc.com/webservice/v1/files/new/4/" + generatedfilename + "/" + company,
									success:	function(data) {
														$(document).ready(function() {
															$('#file-form').each(function(){
																this.reset();
															});
															getFiles();
															stopSpinner();
															$.toast({heading: "Success",text: "File successfully uploaded.", icon: "success"});
														});	
													},
									error:		function(xhr, status, error) {
														$(document).ready(function() {
															stopSpinner();
															$.toast({heading: "Error",text: "", icon: "error"});
														});
													}
								});
							});
						});		
					} else {
						$(document).ready(function() {
							$.toast({heading: "Error",text: "", icon: "error"});
						});
					}
				}
			};
			xhr.send(formData);
		}
	}
	function showNewFileFields() {
		document.getElementById("file-form").style.display = "block";
		document.getElementById("manageFile").href = "javascript:hideNewFileFields()";
		document.getElementById("iconManageFile").className = "fa fa-minus-circle"; 
	}
	function hideNewFileFields() {
		document.getElementById("file-form").style.display = "none";
		document.getElementById("manageFile").href = "javascript:showNewFileFields()";
		document.getElementById("iconManageFile").className = "fa fa-plus-circle"; 
	}
	var spinner = new Spinner(opts);
	function startSpinner() {
		document.getElementById('spinner').style.display = "block";
		spinner.spin(document.getElementById('spinner'));
	}
	function stopSpinner() {
		document.getElementById('spinner').style.display = "none";
		spinner.stop();
	}
	</script>
</head>
<body>
	<?php include('../header/navbar.php'); ?>
	<img src="../../images/background/documents.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-left margin-bottom-20">
				<a href="../accueil.php">
						<h5><i class="fa fa-chevron-left"></i> <?php echo $documents['BACK'];?></h5>
				</a>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-right margin-bottom-20">
				<div align="right">
					<h5>
						<a id="manageFile" href="javascript:showNewFileFields();">
							<i id="iconManageFile" class="fa fa-plus-circle"></i>
							 <?php echo $documents['ADD_FILE'];?>
						</a>
					</h5>
				</div>
			</div>
		</div>
		<div class="templatemo-content">
			<div class="black-bg btn-menu margin-bottom-20">
				<h2><?php echo $documents['COMPANYS_DOCS'];?></h2>
				<div class="panel-body">
					<form id="file-form" action="javascript:uploadFile();" method="POST">
						<table>
							<tr>
								<td id="files" colspan="2">
									<table class="display" id="fileslist">
										
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<h5><input class="form-group" type="file" id="file-select" name="myfiles"/></h5>
								</td>
								<td align="right">
									<button type="submit" id="upload-button" class="btn btn-success"><?php echo $documents['UPLOAD'];?></button>
								</td>
							</tr>
						</table>
						<hr>
					</form>
					<div id="documents">
						<!-- Here, DataTable of list of files -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('../footer/footer.php'); ?>
</body>
</html>
