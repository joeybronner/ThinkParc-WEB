<?php
class Vehicles {	

    /**
     * Return all vehicles with all fields.
     *
     * @url GET /vehicles/all
     */
    public function getAllVehicles() {
		// SQL Request
		$query = mysql_query(	
								"SELECT id, misecirculation, kilometrage, id_energie," .
								" id_genre, id_categorie, numerodeserie, dateachat, date," .
								" id_equipement, commentaire, id_etat, matricule, id_affectation," .
								" id_modele, id_marque" .
								" FROM vehicule"
							);
		// Execute and read result
        $jsonObj = array();
		while($result=mysql_fetch_object($query)) {
		  $jsonObj[] = $result;
		}
		// Return
		return $jsonObj;
    }
}
?>