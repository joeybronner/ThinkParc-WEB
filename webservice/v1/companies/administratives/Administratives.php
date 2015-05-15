<?php
class Administratives {
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/administratives/insurances/all
     */
    public function getAllInsurances($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM insurances ".
					"WHERE id_company = ".$id_company.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url GET /companies/$id_company/administratives/$id_vehicle
     */
    public function getInsurance($id_company = null, $id_vehicle = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM docsadministrative ".
					"WHERE id_company = ".$id_company." ".
					"AND id_vehicle = ".$id_vehicle.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/administratives/vehicles/drivers
     */
    public function getDriversByCompanies($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM drivers ".
					"WHERE id_company = ".$id_company.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/administratives/vehicles/$id_vehicle/drivers
     */
    public function getDrivers($id_company = null, $id_vehicle = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM drivers dr, driveduration dd ".
					"WHERE dr.id_company = ".$id_company." ".
					"AND dd.id_vehicle = ".$id_vehicle." ".
					"AND dd.id_driver = dr.id_driver";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url POST /companies/$id_company/administratives/vehicles/$id_vehicle/driver/existant/$id_driver/$date_start/$date_end
     */
    public function addDriveDuration($id_company = null, $id_vehicle = null, $id_driver = null, $date_start = null, $date_end = null) {
		try {
			global $con;
			$sql = 	"INSERT INTO driveduration (id_vehicle, id_driver, date_start, date_end) ".
					"VALUES (".$id_vehicle.", ".$id_driver.", '".$date_start."', '".$date_end."');";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url POST /companies/$id_company/administratives/vehicles/drivers/$firstname/$lastname/$nr_drivinglicence
     */
    public function addNewDriver($id_company = null, $firstname = null, $lastname = null, $nr_drivinglicence = null) {
		try {
			global $con;
			$sql = 	"INSERT INTO drivers (firstname, lastname, nr_drivinglicence, id_company) ".
					"VALUES ('".$firstname."', '".$lastname."', '".$nr_drivinglicence."', ".$id_company.");";
			$stmt = $con->exec($sql);
			$id = $con->lastInsertId('id_driver');
			return array("Success" => "".$id);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url DELETE /companies/$id_company/administratives/driveduration/$id_driveduration
     */
    public function removeDriveDuration($id_company = null, $id_driveduration = null) {
		try {
			global $con;
			$sql = 	"DELETE FROM driveduration ".
					"WHERE id_driveduration = ".$id_driveduration.";";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url POST /companies/$id_company/administratives/docs/$id_vehicle/$nr_contract/$date_lastcontrol/$date_nextcontrol/$date_startinsurance/$date_endinsurance/$id_insurance
     */
    public function addDocAdministrative($id_company = null, $id_vehicle = null, $nr_contract = null, $date_lastcontrol = null,
								$date_nextcontrol = null, $date_startinsurance = null, $date_endinsurance = null, $id_insurance = null, $data) {
		try {
			global $con;
			$sql = 	"INSERT INTO docsadministrative (id_vehicle, nr_contract, date_lastcontrol, date_nextcontrol, date_startinsurance, date_endinsurance, id_insurance, id_company) ".
					"VALUES (".$id_vehicle.", '".$nr_contract."', '".$date_lastcontrol."', '".$date_nextcontrol."', '".$date_startinsurance."', '".$date_endinsurance."', ".$id_insurance.", ".$id_company.");";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url POST /companies/$id_company/administratives/insurances/$name/$phone/$email/$address_ligne1/$address_ligne2/$address_ligne3/$zipcode/$city/$country
     */
    public function addInsurance($id_company = null, $name = null, $phone = null, $email = null, $address_ligne1 = null, 
											$address_ligne2 = null, $address_ligne3 = null, $zipcode = null, $city = null, 
											$country = null, $data) {
		try {
			global $con;
			$sql = 	"INSERT INTO insurances (name, phone, email, address_ligne1, address_ligne2, address_ligne3, zipcode, city, country, id_company) ".
					"VALUES ('".$name."', '".$phone."', '".$email."', '".$address_ligne1."', '".$address_ligne2."', '".$address_ligne3."', '".$zipcode."', '".$city."', '".$country."', '".$id_company."')";
			$stmt = $con->exec($sql);
			$id = $con->lastInsertId('id_insurance');
			return array("Success" => "".$id);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url PUT /companies/$id_company/administratives/docs/$id_vehicle/$nr_contract/$date_lastcontrol/$date_nextcontrol/$date_startinsurance/$date_endinsurance/$id_insurance
     */
    public function updateDocAdministrative($id_company = null, $id_vehicle = null, $nr_contract = null, $date_lastcontrol = null,
								$date_nextcontrol = null, $date_startinsurance = null, $date_endinsurance = null, $id_insurance = null, $data) {
		try {
			global $con;
			$sql = 	"UPDATE docsadministrative ".
					"SET nr_contract = '".$nr_contract."', date_lastcontrol = '".$date_lastcontrol."', date_nextcontrol = '".$date_nextcontrol."', date_startinsurance = '".$date_startinsurance."', date_endinsurance = '".$date_endinsurance."', id_insurance = ".$id_insurance." ".
					"WHERE id_vehicle = ".$id_vehicle.";";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
	 * @url OPTIONS /companies/$id_company/administratives/docs/$id_vehicle/$nr_contract/$date_lastcontrol/$date_nextcontrol/$date_startinsurance/$date_endinsurance/$id_insurance
     * @url OPTIONS /companies/$id_company/administratives/driveduration/$id_driveduration
	 */
    public function optionsUnusedMethods($id = null, $data) { return ""; }

}
?>