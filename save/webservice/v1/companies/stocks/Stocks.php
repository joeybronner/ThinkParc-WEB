<?php
class Stocks {	

    /**
     * Return all vehicles for a specific company.
     *
     * @url GET /stocks/family
     */
    public function getFamily() {
		try {
			global $con;
			$sql = "SELECT family FROM family";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }

}
?>