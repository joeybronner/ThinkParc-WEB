<?php

/* ======================================================================== *
 * @filename:		Administratives.php										*
 * @topic:			Administratives 										*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @remarks:		-														*
 *																			*
 * Date       | Developer      | Changes description						*
 * ------------------------------------------------------------------------ *
 * 07/05/2015 | J.BRONNER      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/
 
class Administratives {
	
    /**
     * Retrieves all insurances for a company.
     *
     * @url GET /companies/$id_company/administratives/insurances/all
     */
    public function getAllInsurances($id_company = null) {
		try {			
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM insurances ".
					"WHERE id_company = :id_company";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_company', $id_company);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return $stmt->fetchAll(PDO::FETCH_OBJ);
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Retrieves insurance used for a vehicle.
     *
     * @url GET /companies/$id_company/administratives/$id_vehicle
     */
    public function getInsurance($id_company = null, $id_vehicle = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM docsadministrative ".
					"WHERE id_company = :id_company ".
					"AND id_vehicle = :id_vehicle";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_company', $id_company);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return $stmt->fetchAll(PDO::FETCH_OBJ);
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Retrieves all drivers for a company.
     *
     * @url GET /companies/$id_company/administratives/vehicles/drivers
     */
    public function getDriversByCompanies($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM drivers ".
					"WHERE id_company = :id_company";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_company', $id_company);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return $stmt->fetchAll(PDO::FETCH_OBJ);
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Retrieves a specific driver.
     *
     * @url GET /companies/$id_company/administratives/vehicles/$id_vehicle/drivers
     */
    public function getDrivers($id_company = null, $id_vehicle = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM drivers dr, driveduration dd ".
					"WHERE dr.id_company = :id_company ".
					"AND dd.id_vehicle = :id_vehicle ".
					"AND dd.id_driver = dr.id_driver";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_company', $id_company);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return $stmt->fetchAll(PDO::FETCH_OBJ);
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Adds a news drive duration (driver / vehicle).
     *
     * @url POST /companies/$id_company/administratives/vehicles/$id_vehicle/driver/existant/$id_driver/$date_start/$date_end
     */
    public function addDriveDuration($id_company = null, $id_vehicle = null, $id_driver = null, $date_start = null, $date_end = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO driveduration (id_vehicle, id_driver, date_start, date_end) ".
					"VALUES (:id_vehicle, :id_driver, :date_start, :date_end)";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			$stmt->bindParam(':id_driver', $id_driver);
			$stmt->bindParam(':date_start', $date_start);
			$stmt->bindParam(':date_end', $date_end);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return array("success" => "OK");
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Adds a new driver for a company (with driving licence number, etc...).
     *
     * @url POST /companies/$id_company/administratives/vehicles/drivers/$firstname/$lastname/$nr_drivinglicence/$acquisition_drivinglicence/$expire_drivinglicence
     */
    public function addNewDriver($id_company = null, $firstname = null, $lastname = null, $nr_drivinglicence = null, 
						$acquisition_drivinglicence = null, $expire_drivinglicence = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO drivers (firstname, lastname, nr_drivinglicence, acquisition_drivinglicence, expire_drivinglicence, id_company) ".
					"VALUES (:firstname, :lastname, :nr_drivinglicence, :acquisition_drivinglicence, :expire_drivinglicence, :id_company)";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':firstname', $firstname);
			$stmt->bindParam(':lastname', $lastname);
			$stmt->bindParam(':nr_drivinglicence', $nr_drivinglicence);
			$stmt->bindParam(':acquisition_drivinglicence', $acquisition_drivinglicence);
			$stmt->bindParam(':expire_drivinglicence', $expire_drivinglicence);
			$stmt->bindParam(':id_company', $id_company);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno) {
			  throw new PDOException($stmt->error);
			} else {
			  $id = $con->lastInsertId('id_driver');
			  return array("Success" => "".$id);
			}
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Deletes a drive duration.
     *
     * @url DELETE /companies/$id_company/administratives/driveduration/$id_driveduration
     */
    public function removeDriveDuration($id_company = null, $id_driveduration = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"DELETE FROM driveduration ".
					"WHERE id_driveduration = :id_driveduration";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_driveduration', $id_driveduration);
					
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else 
			  return array("success" => "OK");
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Adds a new administrative document for a vehicle (insurance and control dates).
     *
     * @url POST /companies/$id_company/administratives/docs/$id_vehicle/$nr_contract/$date_lastcontrol/$date_nextcontrol/$date_startinsurance/$date_endinsurance/$id_insurance
     */
    public function addDocAdministrative($id_company = null, $id_vehicle = null, $nr_contract = null, $date_lastcontrol = null,
								$date_nextcontrol = null, $date_startinsurance = null, $date_endinsurance = null, $id_insurance = null, $data) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO docsadministrative (id_vehicle, nr_contract, date_lastcontrol, date_nextcontrol, date_startinsurance, date_endinsurance, id_insurance, id_company) ".
					"VALUES (:id_vehicle, :nr_contract, :date_lastcontrol, :date_nextcontrol, :date_startinsurance, :date_endinsurance, :id_insurance, :id_company);";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			$stmt->bindParam(':nr_contract', $nr_contract);
			$stmt->bindParam(':date_lastcontrol', $date_lastcontrol);
			$stmt->bindParam(':date_nextcontrol', $date_nextcontrol);
			$stmt->bindParam(':date_startinsurance', $date_startinsurance);
			$stmt->bindParam(':date_endinsurance', $date_endinsurance);
			$stmt->bindParam(':id_insurance', $id_insurance);
			$stmt->bindParam(':id_company', $id_company);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return array("success" => "OK");
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Adds a news insurance for a company/vehicle.
     *
     * @url POST /companies/$id_company/administratives/insurances/$name/$phone/$email/$address_ligne1/$address_ligne2/$address_ligne3/$zipcode/$city/$country
     */
    public function addInsurance($id_company = null, $name = null, $phone = null, $email = null, $address_ligne1 = null, 
											$address_ligne2 = null, $address_ligne3 = null, $zipcode = null, $city = null, 
											$country = null, $data) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO insurances (name, phone, email, address_ligne1, address_ligne2, address_ligne3, zipcode, city, country, id_company) ".
					"VALUES (:name, :phone, :email, :address_ligne1, :address_ligne2, :address_ligne3, :zipcode, :city, :country, :id_company)";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':address_ligne1', $address_ligne1);
			$stmt->bindParam(':address_ligne2', $address_ligne2);
			$stmt->bindParam(':address_ligne3', $address_ligne3);
			$stmt->bindParam(':zipcode', $zipcode);
			$stmt->bindParam(':city', $city);
			$stmt->bindParam(':country', $country);
			$stmt->bindParam(':id_company', $id_company);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno) {
			  throw new PDOException($stmt->error);
			} else {
			  $id = $con->lastInsertId('id_insurance');
			  return array("Success" => "".$id);
			}
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Updates an administrative vehicle document.
     *
     * @url PUT /companies/$id_company/administratives/docs/$id_vehicle/$nr_contract/$date_lastcontrol/$date_nextcontrol/$date_startinsurance/$date_endinsurance/$id_insurance
     */
    public function updateDocAdministrative($id_company = null, $id_vehicle = null, $nr_contract = null, $date_lastcontrol = null,
								$date_nextcontrol = null, $date_startinsurance = null, $date_endinsurance = null, $id_insurance = null, $data) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"UPDATE docsadministrative ".
					"SET nr_contract = :nr_contract, date_lastcontrol = :date_lastcontrol, date_nextcontrol = :date_nextcontrol, date_startinsurance = :date_startinsurance, date_endinsurance = :date_endinsurance, id_insurance = :id_insurance ".
					"WHERE id_vehicle = :id_vehicle";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':nr_contract', $nr_contract);
			$stmt->bindParam(':date_lastcontrol', $date_lastcontrol);
			$stmt->bindParam(':date_nextcontrol', $date_nextcontrol);
			$stmt->bindParam(':date_startinsurance', $date_startinsurance);
			$stmt->bindParam(':date_endinsurance', $date_endinsurance);
			$stmt->bindParam(':id_insurance', $id_insurance);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno)
			  throw new PDOException($stmt->error);
			else
			  return array("success" => "OK");
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Used to PUT;DELETE requests.
     *
	 * @url OPTIONS /companies/$id_company/administratives/docs/$id_vehicle/$nr_contract/$date_lastcontrol/$date_nextcontrol/$date_startinsurance/$date_endinsurance/$id_insurance
     * @url OPTIONS /companies/$id_company/administratives/driveduration/$id_driveduration
	 */
    public function optionsUnusedMethods($id = null, $data) { return ""; }

}
?>