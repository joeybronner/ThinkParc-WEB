<?php
 /*
 try {
	$db = new PDO(	'mysql:'.
				'host='.$DB_server.';'.
				'dbname='.$DB_database.';'. 
                $DB_username, 
                $DB_password, 
					array
					(
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
						PDO::ATTR_PERSISTENT => false
					)
                );
} catch (PDOException $e) {
	print "Error: " . $e->getMessage() . "<br/>";
    die();
}*/

/* 
 *	Defines database values for different environment
 *		- development (localhost / 127.0.0.1)
 *		- production.
 */ 
if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
	$dbhost = '127.0.0.1'; 
	$dbuser = 'root'; 
	$dbpass = '';
	$dbname = 'fct';
} else {
	$dbhost = 'thinkparqnroot.mysql.db';
	$dbuser = 'thinkparqnroot';
	$dbpass = 'Thinkparc1';
	$dbname = 'thinkparqnroot';
}

/* 
 *	Establish connection
 */ 
$con = new PDO('mysql:host='.$dbhost.'; dbname='.$dbname, $dbuser, $dbpass);  
$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$con->exec("SET CHARACTER SET utf8");

?>