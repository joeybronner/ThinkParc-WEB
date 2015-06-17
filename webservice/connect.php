<?php

$dbhost = 'thinkparqnroot.mysql.db';
$dbuser = 'thinkparqnroot';
$dbpass = 'Thinkparc1';
$dbname = 'thinkparqnroot';

/* 
 *	Establish connection
 */ 
$con = new PDO('mysql:host='.$dbhost.'; dbname='.$dbname, $dbuser, $dbpass);  
$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$con->exec("SET CHARACTER SET utf8");