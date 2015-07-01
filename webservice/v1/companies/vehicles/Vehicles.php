<?php

/* ======================================================================== *
 * @filename:		Vehicles.php											*
 * @topic:			Vehicles 												*
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
 
class Vehicle {
	
    /**
     * Return all vehicles for a specific company.
     *
     * @url GET /companies/vehicles/brands
     */
    public function getAllBrands() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * FROM brands";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			
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
     * Returns all vehicles upload files.
     *
     * @url GET /companies/$id_company/vehicles/$id_vehicle/files
     */
    public function getVehicleFiles($id_company = null, $id_vehicle = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM files, filestypes ".
					"WHERE id_element = :id_vehicle ".
					"AND files.id_filestype = filestypes.id_filestype ".
					"AND files.id_filestype = 1;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
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
     * Returns all models for a specific brand.
     *
     * @url GET /companies/vehicles/models/$id_brand
     */
    public function getModels($id_brand = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM models ".
					"WHERE id_brand = :id_brand;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_brand', $id_brand);
			
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
     * Returns all kinds.
     *
     * @url GET /companies/vehicles/kinds
     */
    public function getKinds() {
		try {			
			global $con;
			/* Statement declaration */
			$sql = "SELECT * FROM kinds";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			
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
     * Returns all categories.
     *
     * @url GET /companies/vehicles/categories
     */
    public function getCategories() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * FROM categories";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			
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
     * Returns all energies.
     *
     * @url GET /companies/vehicles/energies
     */
    public function getEnergies() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * FROM energies";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			
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
     * Returns all sites for a company.
     *
     * @url GET /companies/$id_company/sites
     */
    public function getSites($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM sites ".
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
     * Returns all states.
     *
     * @url GET /companies/vehicles/states
     */
    public function getStates() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * FROM states";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			
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
     * Return all vehicles for a specific company.
     *
     * @url GET /companies/$id_company/vehicles/all
     */
    public function getAllVehiclesByCompany($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM vehicles v, kinds k, brands b, states s, categories c, energies en, models m, sites si, currencies cu ".
					"WHERE v.id_energy = en.id_energy ".
						"AND v.id_model = m.id_model ".
						"AND v.id_kind = k.id_kind ".
						"AND v.id_category = c.id_category ".
						"AND v.id_state = s.id_state ".
						"AND v.id_currency = cu.id_currency ".
						"AND v.id_site = si.id_site ".
						"AND si.id_company = :id_company ".
						"AND m.id_brand = b.id_brand;";
					
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
     * Returns all vehicle's informations.
     *
     * @url GET /companies/vehicles/$id_vehicle
     */
    public function getAllVehicle($id_vehicle = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM vehicles v, kinds k, brands b, states s, categories c, energies en, models m, sites si, currencies cu ".
					"WHERE v.id_vehicle = :id_vehicle ".
						"AND v.id_energy = en.id_energy ".
						"AND v.id_model = m.id_model ".
						"AND v.id_kind = k.id_kind ".
						"AND v.id_category = c.id_category ".
						"AND v.id_state = s.id_state ".
						"AND v.id_currency = cu.id_currency ".
						"AND v.id_site = si.id_site ".
						"AND m.id_brand = b.id_brand;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
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
     * Deletes a vehicle from database.
     *
     * @url DELETE /companies/vehicles/$id_vehicle
     */
    public function deleteVehicle($id_vehicle = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"DELETE FROM vehicles WHERE id_vehicle = :id_vehicle";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
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
     * Adds a new vehicule for a company.
     *
     * @url POST /companies/sites/$id_site/vehicles/$nr_plate/$nr_serial/$mileage/$buyingprice/$date_buy/$date_entryservice/$id_energy/$id_model/$id_kind/$id_category/$equipments/$id_state/$id_currency/$commentary
     */
    public function addVehicule($id_site = null, $nr_plate = null, $nr_serial = null, $mileage = null, 
						$buyingprice = null, $date_buy = null, $date_entryservice = null, $id_energy = null, 
						$id_model = null, $id_kind = null, $id_category = null, $equipments = null, 
						$id_state = null, $id_currency = null, $commentary = null, $data) {
		try {	
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO vehicles (nr_plate, nr_serial, mileage, buyingprice, date_buy, date_add, date_entryservice, id_energy, id_model, id_kind, id_category, equipments, id_state, id_site, id_currency, commentary) ".
					"VALUES (:nr_plate, :nr_serial, :mileage, :buyingprice, :date_buy, NOW(), :date_entryservice, :id_energy, :id_model, :id_kind, :id_category, :equipments, :id_state, :id_site, :id_currency, :commentary);";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':nr_plate', $nr_plate);
			$stmt->bindParam(':nr_serial', $nr_serial);
			$stmt->bindParam(':mileage', $mileage);
			$stmt->bindParam(':buyingprice', $buyingprice);
			$stmt->bindParam(':date_buy', $date_buy);
			$stmt->bindParam(':date_entryservice', $date_entryservice);
			$stmt->bindParam(':id_energy', $id_energy);
			$stmt->bindParam(':id_model', $id_model);
			$stmt->bindParam(':id_kind', $id_kind);
			$stmt->bindParam(':id_category', $id_category);
			$stmt->bindParam(':equipments', $equipments);
			$stmt->bindParam(':id_state', $id_state);
			$stmt->bindParam(':id_site', $id_site);
			$stmt->bindParam(':id_currency', $id_currency);
			$stmt->bindParam(':commentary', $commentary);
			
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
			return array("error" => "".$e->getMessage());
		}
    }
	
	/**
     * Updates values for a vehicle.
     *
     * @url PUT /companies/sites/$id_site/vehicles/$nr_plate/$nr_serial/$mileage/$buyingprice/$date_buy/$date_entryservice/$id_energy/$id_model/$id_kind/$id_category/$equipments/$id_state/$id_currency/$commentary
     */
    public function updateVehicule($id_site = null, $nr_plate = null, $nr_serial = null, $mileage = null, 
						$buyingprice = null, $date_buy = null, $date_entryservice = null, $id_energy = null, 
						$id_model = null, $id_kind = null, $id_category = null, $equipments = null, 
						$id_state = null, $id_currency = null, $commentary = null, $data) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"UPDATE vehicles ".
					"SET nr_serial=:nr_serial, mileage=:mileage, buyingprice=:buyingprice, date_buy=:date_buy, date_entryservice=:date_entryservice, id_energy=:id_energy, id_model=:id_model, id_kind=:id_kind, id_category=:id_category, equipments=:equipments, id_state=:id_state, id_site=:id_site, id_currency=:id_currency, commentary=:commentary ".
					"WHERE nr_plate=:nr_plate";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':nr_serial', $nr_serial);
			$stmt->bindParam(':mileage', $mileage);
			$stmt->bindParam(':buyingprice', $buyingprice);
			$stmt->bindParam(':date_buy', $date_buy);
			$stmt->bindParam(':date_entryservice', $date_entryservice);
			$stmt->bindParam(':id_energy', $id_energy);
			$stmt->bindParam(':id_model', $id_model);
			$stmt->bindParam(':id_kind', $id_kind);
			$stmt->bindParam(':id_category', $id_category);
			$stmt->bindParam(':equipments', $equipments);
			$stmt->bindParam(':id_state', $id_state);
			$stmt->bindParam(':id_site', $id_site);
			$stmt->bindParam(':id_currency', $id_currency);
			$stmt->bindParam(':commentary', $commentary);
			$stmt->bindParam(':nr_plate', $nr_plate);
			
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
			return array("test" => "".$e->getMessage());
		}
    }
	
	/**
     * Used to PUT;DELETE requests.
     *
	 * @url OPTIONS /companies/vehicles/$id_vehicle
	 * @url OPTIONS /companies/sites/$id_site/vehicles/$nr_plate/$nr_serial/$mileage/$buyingprice/$date_buy/$date_entryservice/$id_energy/$id_model/$id_kind/$id_category/$equipments/$id_state/$id_currency/$commentary
     */
    public function optionsUnusedMethods($id = null, $data) { return ""; }


}
?>