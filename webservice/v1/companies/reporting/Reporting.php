<?php
class Reporting {
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/reporting/reference/$reference/start/$date_start/end/$date_end/filter/$filter
     */
    public function getPartPicking($id_company = null, $reference = null, $date_start = null, $date_end = null, $filter = null) {
		try {
			global $con;
			if ($filter == "DAY") {
				$filter = "";
			}
			$sql = 	"SELECT ".$filter."(date_usepart) AS f, YEAR(date_usepart) AS y, SUM(quantity) AS somme ".
					"FROM partsmaintenance pm, parts p, stock s ".
					"WHERE pm.id_stock = s.id_stock ".
					"AND s.id_part = p.id_part ".
					"AND date_usepart BETWEEN '".$date_start."' AND '".$date_end."' ". 
					"AND p.reference = '".$reference."' ". 
					"GROUP BY ".$filter."(date_usepart);";
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
	
}
?>