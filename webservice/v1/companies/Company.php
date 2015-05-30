<?php
class Company {
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/files
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

}
?>