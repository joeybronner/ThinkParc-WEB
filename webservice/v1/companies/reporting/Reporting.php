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
			$sql = 	"SELECT * ";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
}
?>