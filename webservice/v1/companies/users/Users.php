<?php
/* ======================================================================== *
 * @filename:		Users.php												*
 * @topic:			Users 													*
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
 
class Users {	

    /**
     * Updates user's password.
     *
     * @url GET /companies/users/password/update/$id_user/$newpass
     */
    public function updatePassword($id_user = null, $newpass = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"UPDATE users ".
					"SET pass = :newpass ".
					"WHERE id_user = :id_user";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':newpass', $newpass);
			$stmt->bindParam(':id_user', $id_user);
			
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
     * Returns user infos (email, name, ...).
     *
	 * @noAuth
     * @url GET /companies/users/$id_user
     */
    public function getUser($id_user = null) {
		try {
			global $con;			
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM users ".
					"WHERE id_user = :id_user";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_user', $id_user);
			
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
     * Updates user profile picture.
     *
	 * @url PUT /companies/users/$id_user/profilepicture/$image
     */
    public function updateProfilePicture($id_user = null, $image = null, $data) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"UPDATE users ".
					"SET image = :image ".
					"WHERE id_user = :id_user";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':image', $image);
			$stmt->bindParam(':id_user', $id_user);
			
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
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Used to PUT;DELETE requests.
     *
	 * @url OPTIONS /companies/users/$id_user/profilepicture/$image
     */
    public function optionsUnusedMethods($id = null, $data) { return ""; }

}
?>