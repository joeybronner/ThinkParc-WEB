<?php
class Reporting {
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/reference/$reference/start/$date_start/end/$date_end/filter/$filter
     */
    public function getPartUsedForMaintenance($id_company = null, $reference = null, $date_start = null, $date_end = null, $filter = null) {
		try {
			global $con;
			if ($filter == "DAY") {
				$filter = "";
			}
			$sql = 	"SELECT concat(".$filter."(dl.date), YEAR(dl.date)) AS entiere, ".$filter."(dl.date) AS f, YEAR(dl.date) AS y, IFNULL(SUM(quantity), 0) AS somme ".
					"FROM (datelist dl) ".
					"LEFT JOIN parts p ON p.reference = '".$reference."' ".
					"LEFT JOIN stock s ON s.id_part = p.id_part ".
					"LEFT JOIN partsmaintenance pm ON pm.date_usepart = dl.date AND s.id_stock = pm.id_stock ".
					"WHERE dl.date BETWEEN '".$date_start."' AND '".$date_end."' ".
					"GROUP BY entiere ".
					"ORDER BY dl.date ASC;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/reference/transfert/$reference/start/$date_start/end/$date_end/filter/$filter
     */
    public function getPartUsedForTransfert($id_company = null, $reference = null, $date_start = null, $date_end = null, $filter = null) {
		try {
			global $con;
			if ($filter == "DAY") {
				$filter = "";
			}
			$sql = 	"SELECT concat(".$filter."(dl.date), YEAR(dl.date)) AS entiere, ".$filter."(dl.date) AS f, YEAR(dl.date) AS y, IFNULL(SUM(quantity), 0) AS somme ".
					"FROM (datelist dl) ".
					"LEFT JOIN parts p ON p.reference = '".$reference."' ".
					"LEFT JOIN transfert t ON t.transferdate = dl.date AND t.validation = 1 AND p.id_part = t.id_part ".
					"WHERE dl.date BETWEEN '".$date_start."' AND '".$date_end."' ".
					"GROUP BY entiere ".
					"ORDER BY dl.date ASC;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/reference/$reference/stockvalue
     */
    public function getStockValueForReference($id_company = null, $reference = null) {
		try {
			global $con;
			$sql = 	"SELECT IFNULL(SUM(quanty), 0) AS stockquantity, IFNULL((SUM(quanty)*buyingprice), 0) AS marketvalue, IFNULL(symbol, '-') AS symbol ".
					"FROM parts p, stock s, currencies c ".
					"WHERE p.reference = '".$reference."' ".
					"AND p.id_part = s.id_part ".
					"AND id_company = ".$id_company." ".
					"AND p.id_currency = c.id_currency;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/vehicles/currentlyinmaintenance
     */
    public function getVehiclesInMaintenance($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM vehicles v, sites s, maintenance m ".
					"WHERE v.id_site = s.id_site ".
					"AND s.id_company = ".$id_company." ".
					"AND v.id_vehicle = m.id_vehicle ".
					"AND (m.date_endmaintenance > NOW() OR m.date_endmaintenance = '0000-00-00');";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/reference/$reference/localisation
     */
    public function getPartsBySite($id_company = null, $reference = null) {
		try {
			global $con;
			$sql = 	"SELECT name, IFNULL(SUM(quanty), 0) AS partssum ".
					"FROM parts p, stock s, sites si ".
					"WHERE p.reference = '".$reference."' ".
					"AND p.id_part = s.id_part ".
					"AND s.id_site = si.id_site ".
					"AND si.id_company = ".$id_company." ".
					"GROUP BY name;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/insurances/alert
     */
    public function getInsurancesAlert($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM docsadministrative ".
					"WHERE id_company = ".$id_company." ".
					"AND NOW() + INTERVAL 30 DAY >= date_endinsurance";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/technicalcontrol/alert
     */
    public function getTechnicalControlAlert($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM docsadministrative ".
					"WHERE id_company = ".$id_company." ".
					"AND NOW() + INTERVAL 15 DAY >= date_nextcontrol";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/parts/all
     */
    public function getAllParts($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM parts p ".
					"WHERE id_company = ".$id_company.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
}
?>