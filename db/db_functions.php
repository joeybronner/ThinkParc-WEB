<?php
//session_start();
  class db_functions
  {
  public $dbh,$db;
    
	
    public function __construct()
    {
		if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
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
		} else {
			$this->dbh = new PDO('mysql:host=thinkparqnroot.mysql.db;dbname=thinkparqnroot','thinkparqnroot','Thinkparc1', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			// Connection au serveur
			try {
				$dns = 'mysql:host=thinkparqnroot.mysql.db;dbname=thinkparqnroot';
				$user = 'thinkparqnroot';
				$pass = 'Thinkparc1';
				$connection = new PDO( $dns, $user, $pass );
			} catch ( Exception $e ) {
				echo "Connection à MySQL impossible : ", $e->getMessage();
				die();
			}
		}
	}
  
    public function deletevehicule() {
  
		$b=$_GET['id'];
		$sql1 = "delete from vehicule WHERE id='".$b."'";
		echo $sql1;
	    $req1 = $this->dbh->query($sql1);
              
        return $req1;
 }
 
  public function deleteadministratif() {
  
		$b=$_GET['id'];
		$sql1 = "delete from administratif WHERE id='".$b."'";
		echo $sql1;
	    $req1 = $this->dbh->query($sql1);
              
        return $req1;
 }
 
 
 public function getCar() {
 
 	$sql1="SELECT v.id, v.misecirculation, v.kilometrage, v.numerodeserie, v.dateachat, v.commentaire, v.matricule, v.date, m.libelle, mo.modele, en.energie, ge.genre, ca.categorie, eq.equipement, et.etat, af.affectation
				FROM vehicule v, marque m, modele mo, categorie ca, energie en, genre ge, equipement eq, etat et, affectation af 
				WHERE v.id_marque = m.id and v.id_modele = mo.id
				And af.id=v.id
				AND v.id_categorie=ca.id
				AND v.id_energie=en.id
				AND v.id_equipement=eq.id
				AND v.id_etat=et.id
				AND v.id_genre=ge.id";
				
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 
 }
 
  public function getnbCar() {
 
 	$sql1="SELECT  count(id) as total FROM vehicule ";
				
				
                $req1 = $this->dbh->query($sql1);
				$count = $req1->fetch(PDO::FETCH_ASSOC);
                return $count;
 
 }
	
  public function getvehicule() {
 
			
				$sql1="SELECT *
				FROM vehicule v, marque m, modele mo, categorie ca, energie en, genre ge, equipement eq, etat et, affectation af 
				WHERE v.id_marque = m.id and v.id_modele = mo.id
				AND v.id_affectation=af.id
				AND v.id_categorie=ca.id
				AND v.id_energie=en.id
				AND v.id_equipement=eq.id
				AND v.id_etat=et.id
				AND v.id_genre=ge.id";
				
				
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
 
     public function getenergie() {
 

				$sql1="SELECT id,energie FROM energie";

                $req1 = $this->dbh->query($sql1);
              
                return $req1;
					}
					
			public function getaffectation() {
 

				$sql1="SELECT id,affectation FROM affectation";

                $req1 = $this->dbh->query($sql1);
              
                return $req1;
					}
					
					public function getcategorie() {
 

				$sql1="SELECT id,categorie FROM categorie";

                $req1 = $this->dbh->query($sql1);
              
                return $req1;
					}
			
			public function getetat() {
 

				$sql1="SELECT id,etat FROM etat";

                $req1 = $this->dbh->query($sql1);
              
                return $req1;
					}
					
					
			public function getgenre() {
 

				$sql1="SELECT id,genre FROM genre";

                $req1 = $this->dbh->query($sql1);
              
                return $req1;
					}
					
					
								
			public function getequipement() {
 

				$sql1="SELECT id,equipement FROM equipement";

                $req1 = $this->dbh->query($sql1);
              
                return $req1;
					}
					
					
 public function getvehiculeadministratif() {
 
				$a=$_GET['id'];
				
				$sql1="SELECT a.id, a.prixachat, a.derniercontrole, a.prochaincontrole, a.numcontratassurance, a.echeanceassurance, a.conducteur, fo.fournisseur, ass.nomassurance  
				FROM vehicule v, administratif a, fournisseur fo, assurance ass 
				WHERE a.id_vehicule=v.id 
				AND a.id_fournisseur=fo.id
				AND a.id_nomassurance=ass.id
				and a.id_vehicule = '".$a."'";
				
<<<<<<< HEAD
=======
				$sql1="SELECT * FROM vehicule v, administratif a, fournisseur fo, assurance ass 
				WHERE a.id_vehicule=v.id 
				AND a.id_fournisseur=fo.id
				AND a.id_nomassurance=ass.id
				and a.id_vehicule = '".$a."'";
				
>>>>>>> origin/master
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
  public function getassurance() {
 
				$sql1="SELECT id, nomassurance FROM assurance";
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
  public function getfournisseur() {
 
				$sql1="SELECT id, fournisseur FROM fournisseur";
				
                $req1 = $this->dbh->query($sql1);
              
                return $req1;
 }
  
   public function getinfouser() {
 
				$a=$_SESSION['fct_id'];
			
				$sql1="SELECT id, nom, prenom, login, image, email, password FROM users WHERE id = '".$a."'";
				
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
  public function Recordlogo($img)
  {
	$b=$_SESSION['fct_id'];
	
	$sql1=	'UPDATE users ' .
			'SET image= "'.$img.'" ' . 
			'WHERE id="'.$b.'"';
	 
	$req1 = $this->dbh->query($sql1);
	    
	if (!$req1) {
		return "Erreur de requete";
	} else {
        return $req1;
	}
  }
  
	public function updatePassword($password) {
		$id=$_SESSION['fct_id'];
		
		// Prepare request
		$sql1=	'UPDATE users ' .
				'SET password= "'.$password.'" ' .
				'WHERE id="'.$id.'"';
		 
		// Execute request
		$req1 = $this->dbh->query($sql1);
         
		// Return result 
		if (!$req1) {
			return "error";
		} else {
            return $req1;
		}
	}
	
	public function getAllNews() {
		$request="SELECT * FROM news ORDER BY date DESC";		
        return $this->dbh->query($request);
	}
	
	public function addNews($msg, $auteur, $actif) {
		$now = date('Y-m-d H:i:s');
		$msgescaped = mysql_real_escape_string($msg);
		$request =	'INSERT INTO news (date, msg, auteur, actif) ' .
					'VALUES ("'.$now.'", "'.$msgescaped.'", "'.$auteur.'", '.$actif.')';
		$result = $this->dbh->query($request);
		    
		if (!$result) {
			return false;
		} else {
            return true;
		}
	}
	
	public function getRandomActiveNews($limit) {
		$request =	'SELECT * ' .
					'FROM news ' .
					'WHERE actif=1 ' .
					'ORDER BY RAND() ' .
					'LIMIT '.$limit.';';
		return $this->dbh->query($request);
	}
	
	public function getNewsStatus($id) {
		$request =	'SELECT actif ' .
					'FROM news ' .
					'WHERE id='.$id.';';
		$result = $this->dbh->query($request);
		$row = $result->fetch();
		return $row['actif'];
	}
	
	public function updateNewsStatus($id, $newValue) {
		$request =	'UPDATE news ' .
					'SET actif='.$newValue.' ' .
					'WHERE id='.$id.';';
		$this->dbh->query($request);
	}
	
	public function deleteNews($id) {
		$request =	'DELETE FROM news ' .
					'WHERE id='.$id.';';
		$this->dbh->query($request);
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

	
		 $sql1='Insert into Vehicule (id_marque, id_modele, id_genre, id_categorie, misecirculation, kilometrage, id_energie, date, numerodeserie, matricule, dateachat, id_equipement, id_affectation, id_etat, commentaire) 
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
		$g=$_GET['assurance'];
		$h=$_GET['echeanceassurance'];
		$i=$_GET['conducteur'];
		

	
		 $sql1='Insert into administratif (id_vehicule, prixachat, id_fournisseur, derniercontrole, prochaincontrole, numcontratassurance, id_nomassurance, echeanceassurance, conducteur) 
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

