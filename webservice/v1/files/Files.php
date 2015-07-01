<?php

/* ======================================================================== *
 * @filename:		Files.php												*
 * @topic:			Files 													*
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
 
class Files {	
	
    /**
     * Retrieves the file path.
     *
     * @url GET /files/$id_file/path
     */
    public function getFilePath($id_file = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT path ".
					"FROM files ".
					"WHERE id_file = :id_file";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_file', $id_file);
			
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
			return array("error" => "".$e->getMessage());
		}
    }
	
	/**
     * Adds a new file.
     *
     * @url POST /files/new/$id_filestype/$path/$id_element
     */
    public function addFile($id_filestype = null, $path = null, $id_element = null, $data) {
		try {		
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO files (id_filestype, path, date_upload, id_element) ".
					"VALUES (:id_filestype, :path, NOW(), :id_element)";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_filestype', $id_filestype);
			$stmt->bindParam(':path', $path);
			$stmt->bindParam(':id_element', $id_element);
			
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
			return array("test" => "".$e->getMessage());
		}
    }
	
    /**
     * Deletes a file.
     *
     * @url DELETE /files/$id_file
     */
    public function removeFile($id_file = null) {
		try {			
			global $con;
			/* Statement declaration */
			$sql = 	"DELETE FROM files ".
					"WHERE id_file = :id_file";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_file', $id_file);
					
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
			return array("error" => "".$e->getMessage());
		}
    }
	
	/**
     * Used to PUT;DELETE requests.
     *
	 * @url OPTIONS /files/$id_file
	 */
    public function optionsUnusedMethods($id = null, $data) { return ""; }
}
?>