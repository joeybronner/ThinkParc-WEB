<?php

/* ======================================================================== *
 * @filename:		Test.php												*
 * @topic:			Tests 													*
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

class Tests {	
	
    /**
     * Retrieves a news randomly.
     *
     * @url GET /tests/cleaning
     */
    public function databaseCleaningAfterTests() {
		try {
			global $con;
			
			/* DELETE VEHICLE */
			$sqlvehicles = "DELETE FROM vehicles WHERE commentary = 'unittesttodelete';";
			$stmt = $con->prepare($sqlvehicles);
			$stmt->execute();
		
			/* DELETE FILES */
			$sqlfiles = "DELETE FROM files WHERE id_filestype = 0;";
			$stmt = $con->prepare($sqlfiles);
			$stmt->execute();
			
			/* DELETE MAINTENANCE */
			$sqlfiles = "DELETE FROM maintenance WHERE id_vehicle = 34;";
			$stmt = $con->prepare($sqlfiles);
			$stmt->execute();
			
			/* DELETE ADMINISTRATIVE */
			$sqlfiles = "DELETE FROM insurances WHERE id_company = 3;";
			$stmt = $con->prepare($sqlfiles);
			$stmt->execute();
			
			/* DELETE DRIVERS */
			$sqlfiles = "DELETE FROM drivers WHERE id_company = 3;";
			$stmt = $con->prepare($sqlfiles);
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
}
?>