<?php
class Company {
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/files/global
     */
    public function getCompanyFiles($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM files, filestypes ".
					"WHERE id_element = ".$id_company." ".
					"AND files.id_filestype = filestypes.id_filestype ".
					"AND files.id_filestype = 4;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/files/vehicles
     */
    public function getCompanyVehiclesFiles($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM files, filestypes, vehicles ".
					"WHERE files.id_element = vehicles.id_vehicle ".
					"AND vehicles.id_site IN (SELECT id_site FROM sites WHERE id_company = ".$id_company.") ".
					"AND files.id_filestype = filestypes.id_filestype ".
					"AND files.id_filestype = 1;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/files/technical
     */
    public function getCompanyTechnicalFiles($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM files, filestypes, parts ".
					"WHERE id_company = ".$id_company." ".
					"AND id_element = id_part ".
					"AND files.id_filestype = filestypes.id_filestype ".
					"AND files.id_filestype = 2;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }

}
?>