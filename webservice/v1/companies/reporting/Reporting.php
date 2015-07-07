<?php

/* ======================================================================== *
 * @filename:		Reporting.php											*
 * @topic:			Reporting 												*
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
 
class Reporting {
	
    /**
     * Returns reference used for maintenance analysis.
     *
     * @url GET /companies/$id_company/reporting/reference/$reference/start/$date_start/end/$date_end/filter/$filter
     */
    public function getPartUsedForMaintenance($id_company = null, $reference = null, $date_start = null, $date_end = null, $filter = null) {
		try {
			global $con;			
			/* Statement declaration */
			if ($filter == "DAY") {
				$filter = "";
			}
			$sql = 	"SELECT concat(".$filter."(dl.date), YEAR(dl.date)) AS entiere, ".$filter."(dl.date) AS f, YEAR(dl.date) AS y, IFNULL(SUM(quantity), 0) AS somme ".
					"FROM (datelist dl) ".
					"LEFT JOIN parts p ON p.reference = :reference ".
					"LEFT JOIN stock s ON s.id_part = p.id_part ".
					"LEFT JOIN partsmaintenance pm ON pm.date_usepart = dl.date AND s.id_stock = pm.id_stock ".
					"WHERE dl.date BETWEEN :date_start AND :date_end ".
					"GROUP BY entiere ".
					"ORDER BY dl.date ASC;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':reference', $reference);
			$stmt->bindParam(':date_start', $date_start);
			$stmt->bindParam(':date_end', $date_end);
			
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
     * Get total vehicles
     *
     * @url GET /companies/reporting/getTotalVehicles/id_site/$id_site
     */
    public function getTotalVehicles($id_site) {
		try {
			global $con;
			/* Statement declaration */
			                    
			$sql = "SELECT count(*) as total, 
					count(case when id_site = :id_site then 1 end) as bysite 
					FROM vehicles ;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_site', $id_site);
			
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
     * Get total vehicles
     *
     * @url GET /companies/reporting/getTotalValuesVehicles/id_site/$id_site
     */
    public function getTotalValuesVehicles($id_site) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT SUM(buyingprice) as total, symbol 
					FROM vehicles ve, currencies cu
					WHERE id_site = :id_site
					AND ve.id_currency=cu.id_currency;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_site', $id_site);
			
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
     * Get total vehicles
     *
     * @url GET /companies/reporting/getTotalValuesOfStock/id_site/$id_site
     */
    public function getTotalValuesOfStock($id_site) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT SUM(pa.buyingprice*st.quanty) as total, symbol 
					FROM stock st, currencies cu, parts pa
					WHERE st.id_site = :id_site
					AND pa.id_currency=cu.id_currency;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_site', $id_site);
			
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
     * Get total parts
     *
     * @url GET /companies/reporting/getTotalParts/id_site/$id_site
     */
    public function getTotalParts($id_site) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT sum(st.id_part*quanty) as total, pa.reference as part
					FROM stock st, parts pa 
					WHERE st.id_site = :id_site
					AND st.id_part = pa.id_part
					GROUP BY st.id_part
					HAVING count(quanty);";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_site', $id_site);
			
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
     * Reporting get state.
     *
     * @url GET /companies/reporting/getState/id_site/$id_site
     */
    public function getState($id_site) {
		try {
			global $con;
				/* Statement declaration */
			$sql="SELECT state, count(ve.id_state) as total
				  FROM vehicles ve, states st 
				  WHERE ve.id_state = st.id_state
				  AND ve.id_site = :id_site
				  GROUP BY ve.id_state
				  HAVING count(st.id_state) ;";
		
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_site', $id_site);
			
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
     * Returns reference used for transfert analysis.
     *
     * @url GET /companies/$id_company/reporting/reference/transfert/$reference/start/$date_start/end/$date_end/filter/$filter
     */
    public function getPartUsedForTransfert($id_company = null, $reference = null, $date_start = null, $date_end = null, $filter = null) {
		try {
			global $con;			
			/* Statement declaration */
			if ($filter == "DAY") {
				$filter = "";
			}
			$sql = 	"SELECT concat(".$filter."(dl.date), YEAR(dl.date)) AS entiere, ".$filter."(dl.date) AS f, YEAR(dl.date) AS y, IFNULL(SUM(quantity), 0) AS somme ".
					"FROM (datelist dl) ".
					"LEFT JOIN parts p ON p.reference = :reference ".
					"LEFT JOIN transfert t ON t.transferdate = dl.date AND t.validation = 1 AND p.id_part = t.id_part ".
					"WHERE dl.date BETWEEN :date_start AND :date_end ".
					"GROUP BY entiere ".
					"ORDER BY dl.date ASC;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':reference', $reference);
			$stmt->bindParam(':date_start', $date_start);
			$stmt->bindParam(':date_end', $date_end);
			
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
     * Returns maintenance cost for a specific vehicle.
     *
     * @url GET /companies/$id_company/reporting/maintenance/cost/$id_vehicle/start/$date_start/end/$date_end/filter/$filter
     */
    public function getMaintenanceCostForSpecificVehicle($id_company = null, $id_vehicle = null, $date_start = null, $date_end = null, $filter = null) {
		try {
			global $con;			
			/* Statement declaration */
			if ($filter == "DAY") {
				$filter = "";
			}
			$sql = 	"SELECT concat(".$filter."(dl.date), YEAR(dl.date)) AS entiere, ".$filter."(dl.date) AS f, YEAR(dl.date) AS y, IFNULL(SUM(quantity*buyingprice), 0) AS maintcost, IFNULL(symbol, 0) AS symbol " .
					"FROM (datelist dl) ".
							"LEFT JOIN maintenance m ON m.date_startmaintenance = dl.date ".
													"AND m.id_vehicle = :id_vehicle ".
							"LEFT JOIN partsmaintenance pm ON pm.id_maintenance = m.id_maintenance ".
							"LEFT JOIN stock s ON pm.id_stock = s.id_stock ".
							"LEFT JOIN parts p ON s.id_part = p.id_part ".
							"LEFT JOIN currencies c ON c.id_currency = p.id_currency ".
					"WHERE dl.date BETWEEN :date_start AND :date_end ".
					"GROUP BY entiere ".
					"ORDER BY dl.date ASC;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			$stmt->bindParam(':date_start', $date_start);
			$stmt->bindParam(':date_end', $date_end);
			
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
     * Returns all parts used for a specific maintenance vehicle.
     *
     * @url GET /companies/$id_company/reporting/maintenance/parts/$id_vehicle/start/$date_start/end/$date_end/filter/$filter
     */
    public function getMaintenancePartsForSpecificVehicle($id_company = null, $id_vehicle = null, $date_start = null, $date_end = null, $filter = null) {
		try {
			global $con;			
			/* Statement declaration */
			if ($filter == "DAY") {
				$filter = "";
			}
			$sql = 	"SELECT concat(".$filter."(dl.date), YEAR(dl.date)) AS entiere, ".$filter."(dl.date) AS f, YEAR(dl.date) AS y, IFNULL(SUM(quantity), 0) AS maintparts, IFNULL(measurement, 0) AS measure " .
					"FROM (datelist dl) ".
							"LEFT JOIN maintenance m ON m.date_startmaintenance = dl.date ".
													"AND m.id_vehicle = :id_vehicle ".
							"LEFT JOIN partsmaintenance pm ON pm.id_maintenance = m.id_maintenance ".
							"LEFT JOIN stock s ON pm.id_stock = s.id_stock ".
							"LEFT JOIN parts p ON s.id_part = p.id_part ".
							"LEFT JOIN measurement me ON me.id_measurement = s.id_measurement ".
					"WHERE dl.date BETWEEN :date_start AND :date_end ".
					"GROUP BY entiere ".
					"ORDER BY dl.date ASC;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			$stmt->bindParam(':date_start', $date_start);
			$stmt->bindParam(':date_end', $date_end);
			
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
     * Returns stocks values available for a reference.
     *
     * @url GET /companies/$id_company/reporting/reference/$reference/stockvalue
     */
    public function getStockValueForReference($id_company = null, $reference = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT IFNULL(SUM(quanty), 0) AS stockquantity, IFNULL((SUM(quanty)*buyingprice), 0) AS marketvalue, IFNULL(symbol, '-') AS symbol ".
					"FROM parts p, stock s, currencies c ".
					"WHERE p.reference = :reference ".
					"AND p.id_part = s.id_part ".
					"AND id_company = :id_company ".
					"AND p.id_currency = c.id_currency;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':reference', $reference);
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
     * Returns all parts used for a vehicle during a range of date.
     *
     * @url GET /companies/$id_company/reporting/vehicles/usedparts/$id_vehicle/$date_start/$date_end
     */
    public function getPartsUsedForAVehicle($id_company = null, $id_vehicle = null, $date_start = null, $date_end = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT reference, SUM(pm.quantity) AS qt ".
					"FROM maintenance m, partsmaintenance pm, stock s, parts p ".
					"WHERE m.id_maintenance = pm.id_maintenance ".
					"AND m.id_vehicle = :id_vehicle ".
					"AND date_startmaintenance BETWEEN :date_start AND :date_end ".
					"AND pm.id_stock = s.id_stock ".
					"AND p.id_part = s.id_part ".
					"GROUP BY reference";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			$stmt->bindParam(':date_start', $date_start);
			$stmt->bindParam(':date_end', $date_end);
			
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
     * Returns all types of maintenance for a vehicle.
     *
     * @url GET /companies/$id_company/reporting/vehicles/typemaintenance/$id_vehicle/$date_start/$date_end
     */
    public function getTypesOfMaintenanceByVehicle($id_company = null, $id_vehicle = null, $date_start = null, $date_end = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT tm.typemaintenance, COUNT(tm.typemaintenance) AS sumtm, IFNULL(SUM(id_vehicle), 0) AS cancelnull ".
					"FROM typemaintenance tm ".
					"LEFT JOIN maintenance m ON tm.id_typemaintenance = m.id_typemaintenance ".
											"AND m.id_vehicle = :id_vehicle ".
											"AND m.date_startmaintenance BETWEEN :date_start AND :date_end ".
					"GROUP BY tm.typemaintenance";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_vehicle', $id_vehicle);
			$stmt->bindParam(':date_start', $date_start);
			$stmt->bindParam(':date_end', $date_end);
			
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
     * Returns all vehicles actually in maintenance.
     *
     * @url GET /companies/$id_company/reporting/vehicles/currentlyinmaintenance
     */
    public function getVehiclesInMaintenance($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM vehicles v, sites s, maintenance m ".
					"WHERE v.id_site = s.id_site ".
					"AND s.id_company = :id_company ".
					"AND v.id_vehicle = m.id_vehicle ".
					"AND (m.date_endmaintenance > NOW() OR m.date_endmaintenance = '0000-00-00');";
					
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
     * Returns parts stock by site for a reference.
     *
     * @url GET /companies/$id_company/reporting/reference/$reference/localisation
     */
    public function getPartsBySite($id_company = null, $reference = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT name, IFNULL(SUM(quanty), 0) AS partssum ".
					"FROM parts p, stock s, sites si ".
					"WHERE p.reference = :reference ".
					"AND p.id_part = s.id_part ".
					"AND s.id_site = si.id_site ".
					"AND si.id_company = :id_company ".
					"GROUP BY name;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':reference', $reference);
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
     * Returns insurance quick view with alert.
     *
     * @url GET /companies/$id_company/reporting/insurances/alert
     */
    public function getInsurancesAlert($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM docsadministrative ".
					"WHERE id_company = :id_company ".
					"AND NOW() + INTERVAL 30 DAY >= date_endinsurance";
					
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
     * Returns technical control quick view with alert.
     *
     * @url GET /companies/$id_company/reporting/technicalcontrol/alert
     */
    public function getTechnicalControlAlert($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM docsadministrative ".
					"WHERE id_company = :id_company ".
					"AND NOW() + INTERVAL 15 DAY >= date_nextcontrol";
					
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
     * Returns all parts for a company.
     *
     * @url GET /companies/$id_company/reporting/parts/all
     */
    public function getAllParts($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM parts p ".
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
	
}
?>