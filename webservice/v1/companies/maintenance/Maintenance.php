<?php

/* ======================================================================== *
 * @filename:		Maintenance.php											*
 * @topic:			Maintenance 											*
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
 
class Maintenance {
	
    /**
     * Returns all available vehicles (not in maintenance).
     *
     * @url GET /companies/$id_company/maintenance/freevehicles
     */
    public function getCompanyFreeVehicles($id_company = null) {
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
						"AND m.id_brand = b.id_brand ".
						"AND v.id_vehicle NOT IN (SELECT id_vehicle FROM maintenance WHERE date_endmaintenance > NOW()) ".
						"AND v.id_vehicle NOT IN (SELECT id_vehicle FROM maintenance WHERE date_endmaintenance = '0000-00-00');";
					
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
     * Returns the maintenance for a vehicle.
     *
     * @url GET /companies/$id_company/maintenance/vehicle/$id_vehicle
     */
    public function getVehicleInMaintenance($id_company = null, $id_vehicle = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM vehicles v, kinds k, brands b, states s, categories c, energies en, models m, sites si, currencies cu, maintenance ma ".
					"WHERE v.id_energy = en.id_energy ".
						"AND v.id_model = m.id_model ".
						"AND v.id_kind = k.id_kind ".
						"AND v.id_category = c.id_category ".
						"AND v.id_state = s.id_state ".
						"AND v.id_currency = cu.id_currency ".
						"AND v.id_site = si.id_site ".
						"AND si.id_company = :id_company ".
						"AND m.id_brand = b.id_brand ".
						"AND v.id_vehicle = ma.id_vehicle ".
						"AND (ma.date_endmaintenance = '0000-00-00' OR ma.date_endmaintenance > CURDATE()) ".
						"AND v.id_vehicle = :id_vehicle";
					
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
     * Returns the number of days in maintenance and available for a vehicle.
     *
     * @url GET /companies/$id_company/maintenance/vehicle/$id_vehicle/daysmaintenance
     */
    public function getVehicleDaysInMaintenance($id_company = null, $id_vehicle = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT SUM(date_endmaintenance - date_startmaintenance) AS maintenancedays ".
					"FROM maintenance m ".
					"WHERE m.id_vehicle = :id_vehicle ".
					"AND m.date_endmaintenance <> '0000-00-00';";
					
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
     * Returns used parts for a maintenance.
     *
     * @url GET /companies/$id_company/maintenance/vehicle/$id_vehicle/partsused
     */
    public function getVehiclePartsUsed($id_company = null, $id_vehicle = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT SUM(quantity) AS quantity ".
					"FROM maintenance m , partsmaintenance p ".
					"WHERE m.id_vehicle = :id_vehicle ".
					"AND m.id_maintenance = p.id_maintenance;";
					
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
     * Returns an history of all maintenances for a specific vehicle.
     *
     * @url GET /companies/$id_company/maintenance/vehicle/$id_vehicle/allmaintenances
     */
    public function getAllMaintenanceForSpecificVehicle($id_company = null, $id_vehicle = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM vehicles v, kinds k, brands b, states s, categories c, energies en, models m, sites si, currencies cu, maintenance ma, typemaintenance tm ".
					"WHERE v.id_energy = en.id_energy ".
						"AND v.id_model = m.id_model ".
						"AND v.id_kind = k.id_kind ".
						"AND v.id_category = c.id_category ".
						"AND v.id_state = s.id_state ".
						"AND v.id_currency = cu.id_currency ".
						"AND v.id_site = si.id_site ".
						"AND si.id_company = :id_company ".
						"AND m.id_brand = b.id_brand ".
						"AND v.id_vehicle = ma.id_vehicle ".
						"AND ma.id_typemaintenance = tm.id_typemaintenance ".
						"AND v.id_vehicle = :id_vehicle ";
					
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
     * Returns all parts for a specific maintenance.
     *
     * @url GET /companies/$id_company/maintenance/parts/$id_maintenance
     */
    public function getPartsForSpecificMaintenance($id_company = null, $id_maintenance = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM maintenance m, partsmaintenance p, stock s, parts pa, currencies c ".
					"WHERE m.id_maintenance = p.id_maintenance ".
						"AND p.id_stock = s.id_stock ".
						"AND s.id_part = pa.id_part ".
						"AND p.id_maintenance = :id_maintenance ".
						"AND pa.id_currency = c.id_currency;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_maintenance', $id_maintenance);
			
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
     * Deletes parts in a maintenance.
     *
     * @url DELETE /companies/$id_company/maintenance/$id_maintenance/stock/$id_stock/quantity/$id_quantity
     */
    public function deletePartsMaintenance($id_company = null, $id_maintenance = null, $id_stock = null, $id_quantity = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"DELETE FROM partsmaintenance ".
					"WHERE id_maintenance = :id_maintenance ".
						"AND id_stock = :id_stock ".
						"AND quantity = :id_quantity";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_maintenance', $id_maintenance);
			$stmt->bindParam(':id_stock', $id_stock);
			$stmt->bindParam(':id_quantity', $id_quantity);
					
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
     * Deletes a global vehicle maintenance.
     *
     * @url DELETE /companies/$id_company/maintenance/$id_maintenance
     */
    public function deleteMaintenance($id_company = null, $id_maintenance = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"DELETE FROM maintenance ".
					"WHERE id_maintenance = :id_maintenance";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_maintenance', $id_maintenance);
					
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
     * Returns all vehicle actually in maintenance.
     *
     * @url GET /companies/$id_company/maintenance/vehiclesundermaintenance
     */
    public function getCompanyUnderMaintenanceVehicles($id_company = null) {
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
						"AND m.id_brand = b.id_brand ".
						"AND (v.id_vehicle IN (SELECT id_vehicle FROM maintenance WHERE date_endmaintenance > NOW()) ".
						"OR v.id_vehicle IN (SELECT id_vehicle FROM maintenance WHERE date_endmaintenance = '0000-00-00'));";
					
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
     * Returns all type of maintenance.
     *
     * @url GET /companies/maintenance/typemaintenance
     */
    public function getTypeMaintenace() {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT * FROM typemaintenance;";
			/* Statement execution */
			$stmt = $con->query($sql);
			/* Statement result */
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Returns stock availability for a reference.
     *
     * @url GET /companies/$id_company/maintenance/stock/$reference/quantity/$quantity
     */
    public function getAvailableStockForReference($id_company = null, $reference = null, $quantity = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM stock s, parts p, sites si, currencies c ".
					"WHERE s.id_part = p.id_part ".
						"AND p.reference = :reference ".
						"AND s.quanty >= :quantity ".
						"AND s.id_site = si.id_site ".
						"AND p.id_currency = c.id_currency ".
						"AND s.id_site IN (SELECT id_site FROM sites WHERE id_company = :id_company);";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':reference', $reference);
			$stmt->bindParam(':quantity', $quantity);
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
     * Adds a vehicle in maintenance.
     *
     * @url POST /companies/$id_company/maintenance/vehicle/$id_vehicle/start/$date_startmaintenance/end/$date_endmaintenance/type/$id_typemaintenance/hours/$labour_hours/rate/$labour_hourlyrate/curr/$id_currency/commentary/$commentary
     */
    public function addVehicleInMaintenance($id_company = null, $id_vehicle = null, $date_startmaintenance = null, $date_endmaintenance = null, 
												$id_typemaintenance = null, $labour_hours = null, $labour_hourlyrate = null, $id_currency = null, 
												$commentary = null, $data) {
		try {			
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO maintenance (id_vehicle, date_startmaintenance, date_endmaintenance, ".
												"id_typemaintenance, labour_hours, labour_hourlyrate, ".
												"id_currency, commentary) ".
					"VALUES (:id_vehicle, :date_startmaintenance, :date_endmaintenance, :id_typemaintenance, :labour_hours, :labour_hourlyrate, :id_currency, :commentary)";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			$stmt->bindParam(':date_startmaintenance', $date_startmaintenance);
			$stmt->bindParam(':date_endmaintenance', $date_endmaintenance);
			$stmt->bindParam(':id_typemaintenance', $id_typemaintenance);
			$stmt->bindParam(':labour_hours', $labour_hours);
			$stmt->bindParam(':labour_hourlyrate', $labour_hourlyrate);
			$stmt->bindParam(':id_currency', $id_currency);
			$stmt->bindParam(':commentary', $commentary);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno) {
			  throw new PDOException($stmt->error);
			} else {
			  $id = $con->lastInsertId('id_maintenance');
			  return array("id" => "".$id);
			}
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Adds a part for a specific maintenance.
     *
     * @url POST /companies/$id_company/maintenance/$id_maintenance/stock/$id_stock/quantity/$quantity
     */
    public function addPartToMaintenance($id_company = null, $id_maintenance = null, $id_stock = null, $quantity = null, $data) {
		try {			
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO partsmaintenance (id_maintenance, id_stock, quantity, date_usepart)".
					"VALUES (:id_maintenance, :id_stock, :quantity, NOW());";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_maintenance', $id_maintenance);
			$stmt->bindParam(':id_stock', $id_stock);
			$stmt->bindParam(':quantity', $quantity);
			
			/* Statement execution */
			$stmt->execute();
			
			/* Handle errors */
			if ($stmt->errno) {
			  throw new PDOException($stmt->error);
			} else {
			  $id = $con->lastInsertId('id_partsmaintenance');
			  return array("id" => "".$id);
			}
			
			/* Close statement */
			$stmt->close();
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Updates the avalaible parts in stocks used for maintenance.
     *
     * @url PUT /companies/$id_company/stock/$id_stock/quantity/$quantity
     */
    public function updateStockAvailableParts($id_company = null, $id_maintenance = null, $id_stock = null, $quantity = null, $data) {
		try {			
			global $con;
			/* Statement declaration */
			$sql = 	"UPDATE stock ".
					"SET quanty = (quanty - :quantity) ".
					"WHERE id_stock = :id_stock";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':quantity', $quantity);
			$stmt->bindParam(':id_stock', $id_stock);
			
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
     * Description.
     *
     * @url PUT /companies/$id_company/maintenance/$id_maintenance/end/$date_endmaintenance/hours/$labour_hours/rate/$labour_hourlyrate/curr/$id_currency/commentary/$commentary
     */
    public function updateMaintenance($id_company = null, $id_maintenance = null, $date_endmaintenance = null, $labour_hours = null, 
											$labour_hourlyrate = null, $id_currency = null, $commentary = null, $data) {
		try {			
			global $con;
			/* Statement declaration */
			$sql = 	"UPDATE maintenance ".
					"SET date_endmaintenance = :date_endmaintenance, ".
					"labour_hours = :labour_hours, ".
					"labour_hourlyrate = :labour_hourlyrate, ".
					"id_currency = :id_currency, ".
					"commentary = :commentary ".
					"WHERE id_maintenance = :id_maintenance";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':date_endmaintenance', $date_endmaintenance);
			$stmt->bindParam(':labour_hours', $labour_hours);
			$stmt->bindParam(':labour_hourlyrate', $labour_hourlyrate);
			$stmt->bindParam(':id_currency', $id_currency);
			$stmt->bindParam(':commentary', $commentary);
			$stmt->bindParam(':id_maintenance', $id_maintenance);
			
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
	 * @url OPTIONS /companies/$id_company/stock/$id_stock/quantity/$quantity
	 * @url OPTIONS /companies/$id_company/maintenance/$id_maintenance
	 * @url OPTIONS /companies/$id_company/maintenance/$id_maintenance/stock/$id_stock/quantity/$id_quantity
	 * @url OPTIONS /companies/$id_company/maintenance/$id_maintenance/end/$date_endmaintenance/hours/$labour_hours/rate/$labour_hourlyrate/curr/$id_currency/commentary/$commentary
     */
    public function optionsUnusedMethods($id = null, $data) { return ""; }
}
?>