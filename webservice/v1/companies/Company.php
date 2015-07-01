<?php

/* ======================================================================== *
 * @filename:		Company.php												*
 * @topic:			Company 												*
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
 
class Company {
	
    /**
     * Returns all company's global files.
     *
     * @url GET /companies/$id_company/files/global
     */
    public function getCompanyFiles($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM files, filestypes ".
					"WHERE id_element = :id_company ".
					"AND files.id_filestype = filestypes.id_filestype ".
					"AND files.id_filestype = 4;";
					
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
     * Returns all company's vehicle files.
     *
     * @url GET /companies/$id_company/files/vehicles
     */
    public function getCompanyVehiclesFiles($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM files, filestypes, vehicles ".
					"WHERE files.id_element = vehicles.id_vehicle ".
					"AND vehicles.id_site IN (SELECT id_site FROM sites WHERE id_company = :id_company) ".
					"AND files.id_filestype = filestypes.id_filestype ".
					"AND files.id_filestype = 1;";
					
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
     * Returns all company's technical files.
     *
     * @url GET /companies/$id_company/files/technical
     */
    public function getCompanyTechnicalFiles($id_company = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM files, filestypes, parts ".
					"WHERE id_company = :id_company ".
					"AND id_element = id_part ".
					"AND files.id_filestype = filestypes.id_filestype ".
					"AND files.id_filestype = 2;";
					
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