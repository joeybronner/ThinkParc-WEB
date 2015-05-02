<?php
class Vehicle {	

    /**
     * Return all vehicles for a specific company.
     *
     * @url GET /vehicle/$id_vehicule/model
     */
    public function getModel($id_vehicule = null) {
		$dbCon = getConnection();
		$query = "SELECT modele" .
				" FROM vehicules v, modeles mo" .
				" WHERE v.id_modele = mo.id_modele" . 
					" AND v.id_vehicule = 1";
		$handle = $dbCon->prepare($query);
		
		$handle->execute();

		$jsonObj = array();
		$result = $handle->fetchAll(PDO::FETCH_OBJ); 
		foreach($result as $row){
			$jsonObj[] = $result;
		}
		$dbCon = null;

		return $jsonObj;
    }

    /**
     * Return all vehicles for a specific company.
     *
     * @url GET /vehicle/test
     */
    public function getTest() {
		return array("test" => "Simple test.");
    }
}
?>