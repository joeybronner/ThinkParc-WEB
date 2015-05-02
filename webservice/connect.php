<?php

/* 
 *	Defines database values for different environment
 *		- development (localhost / 127.0.0.1)
 *		- production.
 */			
/*
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
*/
/* 
 *	Establish connection
 */
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

function getConnection() {
    try {
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
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    return $conn;
}
?>