<?php
//session_start();
  class maclasse
  {
  public $dbh,$db;
    
	
    public function __construct()
    {
        $this->dbh = new PDO('mysql:host=127.0.0.1;dbname=FCT','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
  
   public function getinfouser() {
 
				$a=$_SESSION['id'];
			
				$sql1="SELECT id, nom, prenom, login, image FROM users WHERE id = '".$a."'";
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
  
  public function Recordlogo()
  {
	$a=$_GET['logo'];
	$b=$_SESSION['id'];

	
		 $sql1='Update users set image= "'.$a.'" where id="'.$b.'"';
		 
		 $req1 = $this->dbh->query($sql1);
		    
		 if (!$req1) {
				return "Erreur de requete";
				} else
				{
                return $req1;
  
				}
  
  
  }
  
  
  public function RecordCar()
	{
		
		$a=$_GET['marque'];
		$b=$_GET['modele'];
		$c=$_GET['misecirculation'];
		$d=$_GET['kilometrage'];
		$e=$_GET['energie'];
		$f=$_GET['nom'];
		$g=$_GET['prenom'];
		$h=$_GET['cartegrise'];
		$i=$_GET['chevaux'];

	
		 $sql1='Insert into Vehicule (marque, modele, misecirculation, kilometrage, energie, nom, prenom, cartegrise, chevaux) 
		 values ("'.$a.'","'.$b.'","'.$c.'","'.$d.'","'.$e.'","'.$f.'","'.$g.'","'.$h.'","'.$i.'")';	
		 
		 $req1 = $this->dbh->query($sql1);
         
		    
		 if (!$req1) {
				return "Erreur de requete";
				} else
				{
                return $req1;
  
				}
		}
				
  
  
  
  
  
  }
?>

