<?php
class Files {	
	
    /**
     * Description.
     *
     * @url GET /files/$id_file/path
     */
    public function getFilePath($id_file = null) {
		try {
			global $con;
			$sql = 	"SELECT path ".
					"FROM files ".
					"WHERE id_file = ".$id_file.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url POST /files/new/$id_filestype/$path/$id_element
     */
    public function addFile($id_filestype = null, $path = null, $id_element = null, $data) {
		try {
			global $con;
			$sql = 	"INSERT INTO files (id_filestype, path, date_upload, id_element) ".
					"VALUES (".$id_filestype.", '".$path."', NOW(), ".$id_element.");";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
    /**
     * Description.
     *
     * @url DELETE /files/$id_file
     */
    public function removeFile($id_file = null) {
		try {
			global $con;
			$sql = 	"DELETE FROM files ".
					"WHERE id_file = ".$id_file.";";
			$stmt = $con->exec($sql);
			return array("Success" => "success");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
	/**
     * Description.
     *
	 * @url OPTIONS /files/$id_file
	 */
    public function optionsUnusedMethods($id = null, $data) { return ""; }
}
?>