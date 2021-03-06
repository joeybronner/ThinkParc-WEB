<?php
/******************************************************************************
 *																			  *
 *							@import CSS & JS files						  	  *
 *																			  *
 **************************************************************************** */
 


/* Bootstrap, jQuery, PHPUnit, Guzzle & Datatables managed by Composer */
require (BASE_PATH . '/vendor/autoload.php');

/* Custom Think-Parc design */
echo '<link  href="' .INCLUDE_PATH. '/css/app.css" rel="stylesheet" type="text/css">';

/* Font Awesome */
echo '<link  href="' .INCLUDE_PATH. '/css/font-awesome.min.css" rel="stylesheet" type="text/css">';

/* Templatemo */
echo '<link  href="' .INCLUDE_PATH. '/css/templatemo_main.css" rel="stylesheet" type="text/css">';
echo '<script src="' .INCLUDE_PATH. '/js/templatemo_script.js"></script>';

/* Toast */
echo '<link  href="' .INCLUDE_PATH. '/css/toast/jquery.toast.css" rel="stylesheet" type="text/css">';
echo '<script src="' .INCLUDE_PATH. '/js/jquery.toast.js"></script>';

/* Datepicker */
echo '<link  href="' .INCLUDE_PATH. '/css/datepicker/datepicker.css" rel="stylesheet" type="text/css">';
echo '<script src="' .INCLUDE_PATH. '/js/bootstrap-datepicker.js"></script>';
	
/* Popup */
echo '<script src="' .INCLUDE_PATH. '/js/popup.js"></script>';

/* Google Chart */
echo '<script src="' .INCLUDE_PATH. '/js/googlecharts.js"></script>';

/* Angular JS */
echo '<script src="' .INCLUDE_PATH. '/js/angular1.4.js"></script>';

/* Crypto md5 */
echo '<script src="' .INCLUDE_PATH. '/js/md5.js"></script>';
?>







