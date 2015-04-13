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
  
    public function deletevehicule() {
  
		$b=$_GET['id'];
		$sql1 = "delete from vehicule WHERE id='".$b."'";
		
	    $req1 = $this->dbh->query($sql1);
              
        return $req1;
 }
 
  public function deleteadministratif() {
  
		$b=$_GET['id'];
		$sql1 = "delete from administratif WHERE id='".$b."'";
		
	    $req1 = $this->dbh->query($sql1);
              
        return $req1;
 }
	
  public function getvehicule() {
 
			
				$sql1="SELECT v.id, libelle, modele, misecirculation, kilometrage, energie, genre, categorie, numerodeserie, dateachat, date, equipement, commentaire, etat, matricule, affectation
				FROM vehicule v, marque m, modele mo WHERE v.id_marque = m.id and v.id_modele = mo.id";
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
 
   public function getvehiculemarque() {
 
			
				$sql1="SELECT id,libelle FROM marque";
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
 
    public function getvehiculemodele() {
 
				$a=$select1;
				
				
					
				//$sql1="SELECT id,modele FROM modele WHERE modele like '%".$a."%'";
				$sql1="SELECT id,modele FROM modele";

				
				
				
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
 
 public function getvehiculee() {
 
				$a=$_POST['id'];
				
				$sql1="SELECT * FROM vehicule v, administratif a WHERE a.id_vehicule=v.id and a.id_vehicule = '".$a."'";
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
  
   public function getinfouser() {
 
				$a=$_SESSION['fct_id'];
			
				$sql1="SELECT id, nom, prenom, login, image FROM users WHERE id = '".$a."'";
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
 
		// Recuperation des véhicules déjà enregistré avec formulaire administratif
    public function getimmatriculationenregistre() {
 
				$a=$_GET['id'];
			
				$sql1="SELECT v.id, matricule FROM vehicule v, administratif a WHERE a.id_vehicule=v.id";
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
		// véhicule non enregistré dans l'administratif
		
      public function getimmatriculation() {
 
			
			
				$sql1="SELECT id, matricule FROM vehicule WHERE id NOT IN ( select id_vehicule from administratif)";
				
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
		$mar=$_GET['marque'];
		$mod=$_GET['modele'];
		$a=$_GET['genre'];
		$b=$_GET['categorie'];
		$c=$_GET['misecirculation'];
		$d=$_GET['kilometrage'];
		$e=$_GET['energie'];
		$f=$_GET['date'];
		$g=$_GET['numerodeserie'];
		$h=$_GET['matricule'];
		$i=$_GET['dateachat'];
		$j=$_GET['equipement'];
		$k=$_GET['affectation'];
		$l=$_GET['etat'];
		$m=$_GET['commentaire'];

	
		 $sql1='Insert into Vehicule (id_marque, id_modele, genre, categorie, misecirculation, kilometrage, energie, date, numerodeserie, matricule, dateachat, equipement, affectation, etat, commentaire) 
		 values ("'.$mar.'","'.$mod.'","'.$a.'","'.$b.'","'.$c.'","'.$d.'","'.$e.'","'.$f.'","'.$g.'","'.$h.'","'.$i.'","'.$j.'","'.$k.'","'.$l.'","'.$m.'")';	
		 
		 
		 
		 $req1 = $this->dbh->query($sql1);
         
		    
		 if (!$req1) {
				return "Erreur de requete";
				} else
				{
                return $req1;
  
				}
		}
				
  public function RecordAdministratif()
	{
		
		$a=$_GET['matricule'];
		$b=$_GET['prixachat'];
		$c=$_GET['fournisseur'];
		$d=$_GET['derniercontrole'];
		$e=$_GET['prochaincontrole'];
		$f=$_GET['numcontratassurance'];
		$g=$_GET['nomassurance'];
		$h=$_GET['echeanceassurance'];
		$i=$_GET['conducteur'];
		

	
		 $sql1='Insert into administratif (id_vehicule, prixachat, fournisseur, derniercontrole, prochaincontrole, numcontratassurance, nomassurance, echeanceassurance, conducteur) 
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

