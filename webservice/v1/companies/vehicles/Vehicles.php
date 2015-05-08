<?php
class Vehicle {
	
    /**
     * Return all vehicles for a specific company.
     *
     * @url GET /companies/vehicles/brands
     */
    public function getAllBrands() {
		try {
			global $con;
			$sql = "SELECT * FROM brands";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description
     *
     * @url GET /companies/vehicles/models/$id_brand
     */
    public function getModels($id_brand = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM models ".
					"WHERE id_brand = ".$id_brand.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description
     *
     * @url GET /companies/vehicles/kinds
     */
    public function getKinds() {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM kinds;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description
     *
     * @url GET /companies/vehicles/categories
     */
    public function getCategories() {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM categories;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }

	/**
     * Description
     *
     * @url GET /companies/vehicles/energies
     */
    public function getEnergies() {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM energies;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description
     *
     * @url GET /companies/vehicles/equipments
     */
    public function getEquipments() {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM equipments;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description
     *
     * @url GET /companies/$id_company/sites
     */
    public function getSites($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM sites ".
					"WHERE id_company = ".$id_company.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description
     *
     * @url GET /companies/vehicles/states
     */
    public function getStates() {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM states;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
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
	
	/**
     * Description.
     *
     * @url POST /companies/sites/$id_site/vehicles/$nr_plate/$nr_serial/$mileage/$buyingprice/$date_buy/$date_entryservice/$id_energy/$id_model/$id_kind/$id_category/$id_equipment/$id_state/$id_currency/$commentary
     */
    public function addVehicule($id_site = null, $nr_plate = null, $nr_serial = null, $mileage = null, 
						$buyingprice = null, $date_buy = null, $date_entryservice = null, $id_energy = null, 
						$id_model = null, $id_kind = null, $id_category = null, $id_equipment = null, 
						$id_state = null, $id_currency = null, $commentary = null, $data) {
		try {
			global $con;
			$sql = 	"INSERT INTO vehicles (nr_plate, nr_serial, mileage, buyingprice, date_buy, date_add, date_entryservice, id_energy, id_model, id_kind, id_category, id_equipment, id_state, id_site, id_currency, commentary) ".
					"VALUES ('".$nr_plate."', '".$nr_serial."', ".$mileage.", ".$buyingprice.", '".$date_buy."', NOW(), '".$date_entryservice."', ".$id_energy.", ".$id_model.", ".$id_kind.", ".$id_category.", ".$id_equipment.", ".$id_state.", ".$id_site.", ".$id_currency.", '".$commentary."');";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }

}
?>