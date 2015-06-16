<?php
if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
	set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );
	$base_path = '/projects/ThinkParc-WEB/';
	$include = $base_path;
} else {
	$base_path = $_SERVER['DOCUMENT_ROOT'];
	$include = "";
}

// Define the directory path to include files.
define('BASE_PATH', $base_path);
define('INCLUDE_PATH', $include);
?>