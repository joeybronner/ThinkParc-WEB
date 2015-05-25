<?php
if(!isset($_SESSION)) {
    session_start();
}
// DIR path
if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
	set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );
	$path = '/projects/ThinkParc-WEB/';
	$include = '/projects/ThinkParc-WEB/';
} else {
	$path = "/";
	$include = $_SERVER['DOCUMENT_ROOT']."/";
}
// Language
if($_SESSION['fct_lang'] == 'FR')
	include($include.'lang/header/navbar.fr.php');
else
	include($include.'lang/header/navbar.en.php');
?>
<div>
   <nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Think-Parc</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
				 
					<li>
						<a href="<?php echo $path; ?>src/accueil.php" class="btn btn-sm btn-link">
							<span class="glyphicon glyphicon-home"></span>
							<?php echo $navbar['HOME']; ?>
						</a>
					</li>
					<li class="hidden-xs">
						<img style="height:40px; width:auto;" src="<?php echo $path; ?>images/logoentreprise.jpg" class="btn btn-xs">
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				    
					<li class="hidden-xs">
						<img style="height:40px; width:auto;" src="<?php echo $path; ?>images/logofct.png" class="btn btn-sm">
					</li>

					<li>
						<a href="<?php echo $path; ?>src/infos/myinformations.php" class="btn btn-sm btn-link">
							<span class="glyphicon glyphicon-user"></span>
							<?php echo $navbar['MY_INFORMATIONS']; ?>
						</a>
					</li>
					<li>
						<a href="<?php echo $path; ?>src/exit/exit.php" class="btn btn-sm btn-danger">
							<?php echo $navbar['LOGOFF']; ?>
							<span class="glyphicon glyphicon-off"></span>
						</a>
					</li>
				</ul>
			</div>
      </div>
   </nav>
</div>