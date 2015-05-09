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
     * @url GET /companies/$id_company/vehicles/all
     */
    public function getAllVehiclesByCompany($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM vehicles ".
					"WHERE id_site IN (SELECT id_site FROM sites WHERE id_company = ".$id_company.");";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	 /**
     * Description
     *
     * @url GET /companies/vehicles/$id_vehicle
     */
    public function getAllVehicle($id_vehicle = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM vehicles v, kinds k, brands b, states s, categories c, equipments e, energies en, models m, sites si, currencies cu ".
					"WHERE v.id_vehicle =".$id_vehicle." ".
						"AND v.id_energy = en.id_energy ".
						"AND v.id_model = m.id_model ".
						"AND v.id_kind = k.id_kind ".
						"AND v.id_category = c.id_category ".
						"AND v.id_equipment = e.id_equipment ".
						"AND v.id_state = s.id_state ".
						"AND v.id_currency = cu.id_currency ".
						"AND v.id_site = si.id_site ".
						"AND m.id_brand = b.id_brand;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	 /**
     * Description
     *
     * @url DELETE /companies/vehicles/$id_vehicle
     */
    public function deleteVehicle($id_vehicle = null) {
		try {
			global $con;
			$sql = 	"DELETE FROM vehicles WHERE id_vehicle = ".$id_vehicle.";";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
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
	
	/**
     * Description.
     *
     * @url PUT /companies/sites/$id_site/vehicles/$nr_plate/$nr_serial/$mileage/$buyingprice/$date_buy/$date_entryservice/$id_energy/$id_model/$id_kind/$id_category/$id_equipment/$id_state/$id_currency/$commentary
     */
    public function updateVehicule($id_site = null, $nr_plate = null, $nr_serial = null, $mileage = null, 
						$buyingprice = null, $date_buy = null, $date_entryservice = null, $id_energy = null, 
						$id_model = null, $id_kind = null, $id_category = null, $id_equipment = null, 
						$id_state = null, $id_currency = null, $commentary = null, $data) {
		try {
			global $con;
			$sql = 	"UPDATE vehicles ".
					"SET nr_serial='".$nr_serial."', mileage=".$mileage.", buyingprice=".$buyingprice.", date_buy='".$date_buy."', date_entryservice='".$date_entryservice."', id_energy=".$id_energy.", id_model=".$id_model.", id_kind=".$id_kind.", id_category=".$id_category.", id_equipment=".$id_equipment.", id_state=".$id_state.", id_site=".$id_site.", id_currency=".$id_currency.", commentary='".$commentary."' ".
					"WHERE nr_plate='".$nr_plate."';";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	/**
     * Description.
     *
	 * @url OPTIONS /companies/vehicles/$id_vehicle
	 * @url OPTIONS /companies/sites/$id_site/vehicles/$nr_plate/$nr_serial/$mileage/$buyingprice/$date_buy/$date_entryservice/$id_energy/$id_model/$id_kind/$id_category/$id_equipment/$id_state/$id_currency/$commentary
     */
    public function optionsUnusedMethods($id = null, $data) { return ""; }


}
?>