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


}
?>