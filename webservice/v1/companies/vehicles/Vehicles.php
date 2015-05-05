<?php
class Vehicle {
	
    /**
     * Return all vehicles for a specific company.
     *
     * @url GET /companies/vehicles/models
     */
    public function getAllModels() {
		try {
			global $con;
			$sql = "SELECT * FROM models";
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
     * @url GET /companies/vehicles/all
     */
    public function getAllVehicles() {
		try {
			global $con;
			$sql = "SELECT * FROM vehicles";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }

}
?>