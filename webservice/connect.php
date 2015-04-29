<?php

/* 
 *	Defines database values for different environment
 *		- development (localhost / 127.0.0.1)
 *		- production.
 */			

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
	$DB_server = '127.0.0.1'; 
	$DB_username = 'root'; 
	$DB_password = '';
	$DB_database = 'fct';
} else {
	$DB_server = 'thinkparqnroot.mysql.db';
	$DB_username = 'thinkparqnroot';
	$DB_password = 'Thinkparc1';
	$DB_database = 'thinkparqnroot';
}

/* 
 *	Establish connection
 */	
$con=mysql_connect($DB_server,$DB_username,$DB_password);
mysql_select_db($DB_database,$con) or die ("Cannot connect the Database");


?>