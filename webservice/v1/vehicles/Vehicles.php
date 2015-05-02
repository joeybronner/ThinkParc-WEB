<?php
class Vehicles {	

    /**
     * Return all vehicles for a specific company.
     *
     * @url GET /vehicles/$id_entreprise
     */
    public function getAllVehicles($id_entreprise = null) {
		// Prepare request	
		$query = "SELECT id_vehicule, immatriculation, numeroserie, kilometrage, prixachat," .
					" date_achat, date_misecirculation, date_ajout," .
					" energie, marque, modele, genre, categorie, equipement, etat, site, s.id_entreprise" .
					" commentaire" .
				" FROM vehicules v, sites s, energies e, modeles mo, marques ma, genres g, categories c, equipements e, etats t" .
				" WHERE v.id_site = s.id_site" .
					" AND v.id_energie = e.id_energie" .
					" AND v.id_modele = mo.id_modele" . 
					" AND mo.id_marque = ma.id_marque" . 
					" AND v.id_energie = e.id_energie" .
					" AND v.id_genre = g.id_genre" .
					" AND v.id_categorie = c.id_categorie" .
					" AND v.id_equipement = e.id_equipement" .
					" AND v.id_etat = t.id_etat" .
					" AND s.id_entreprise = ?";
		$handle = $db->prepare($query);
		
		// Handle parameters & execute request
		$handle->bindValue(1, $id_entreprise, PDO::PARAM_INT);
		$handle->execute();

		// Fetch result
		$jsonObj = array();
		$result = $handle->fetchAll(\PDO::FETCH_OBJ); 
		foreach($result as $row){
			$jsonObj[] = $result;
		}

		// Return
		return $jsonObj;
    }
	
    /**
     * Return all vehicles for a specific company & site
     *
     * @url GET /vehicles/$id_entreprise/site/$id_site
     */
    public function getAllVehiclesBySite($id_entreprise = null, $id_site = null) {
		// Prepare request	
		$query = "SELECT id_vehicule, immatriculation, numeroserie, kilometrage, prixachat," .
					" date_achat, date_misecirculation, date_ajout," .
					" energie, marque, modele, genre, categorie, equipement, etat, site, s.id_entreprise" .
					" commentaire" .
				" FROM vehicules v, sites s, energies e, modeles mo, marques ma, genres g, categories c, equipements e, etats t" .
				" WHERE v.id_site = s.id_site" .
					" AND v.id_energie = e.id_energie" .
					" AND v.id_modele = mo.id_modele" . 
					" AND mo.id_marque = ma.id_marque" . 
					" AND v.id_energie = e.id_energie" .
					" AND v.id_genre = g.id_genre" .
					" AND v.id_categorie = c.id_categorie" .
					" AND v.id_equipement = e.id_equipement" .
					" AND v.id_etat = t.id_etat" .
					" AND s.id_entreprise = ?" . 
					" AND v.site = ?";
		$handle = $db->prepare($query);
		
		// Handle parameters & execute request
		$handle->bindValue(1, $id_entreprise, PDO::PARAM_INT);
		$handle->bindValue(2, $id_site, PDO::PARAM_INT);
		$handle->execute();

		// Fetch result
		$jsonObj = array();
		$result = $handle->fetchAll(\PDO::FETCH_OBJ); 
		foreach($result as $row){
			$jsonObj[] = $result;
		}

		// Return
		return $jsonObj;
    }
}
?>