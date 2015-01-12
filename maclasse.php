<?php
//session_start();
  class maclasse
  {
  public $dbh,$db;
    
	
    public function __construct()
    {
        
	// Connection au serveur
		try {
		$dns = 'mysql:host=localhost;dbname=FCT';
		$user = 'root';
		$pass = '';
		$connection = new PDO( $dns, $user, $pass );
		} catch ( Exception $e ) {
		echo "Connection à MySQL impossible : ", $e->getMessage();
		die();
	}
  }
  }
?>

