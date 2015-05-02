<?php
class Vehicle {	

    /**
     * Return all vehicles for a specific company.
     *
     * @url GET /vehicle/$id_vehicule/model
     */
    public function getModel($id_vehicule = null) {
		try {
			global $con;
			$sql = "SELECT modele FROM modeles";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
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