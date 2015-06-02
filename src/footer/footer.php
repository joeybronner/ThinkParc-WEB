<?php 
	if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
		$path = '/projects/ThinkParc-WEB/';
	} else {
		$path = '/';
	}
?>
<div id="spinner"></div>
<div class="footer">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<p class="footer-text">
				<a href="<?php echo $path; ?>db/change_lang.php?fct_lang=FR">
					<img style="height:20px; width:auto;" src="<?php echo $path; ?>images/flags/fr.png">
				</a>
				<a href="<?php echo $path; ?>db/change_lang.php?fct_lang=EN">
					<img style="height:20px; width:auto;" src="<?php echo $path; ?>images/flags/en.png">
				</a>
				Copyright &copy; 2015 FCT Partners</td>
			</p>
		</div>
	</div>
</div>