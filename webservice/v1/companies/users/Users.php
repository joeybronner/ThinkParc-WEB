<?php
class Users {	

    /**
     * Description.
     *
     * @url GET /companies/users/password/update/$id_user/$newpass
     */
    public function updatePassword($id_user = null, $newpass = null) {
		try {
			global $con;
			// Update password
			$sql = 	"UPDATE users ".
					"SET pass = \"".$newpass."\" ".
					"WHERE id_user = ".$id_user.";";
			$stmt = $con->exec($sql);
			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
    /**
     * Description.
     *
	 * @noAuth
     * @url GET /companies/users/$id_user
     */
    public function getUser($id_user = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM users ".
					"WHERE id_user = ".$id_user.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
	 * @url PUT /companies/users/$id_user/profilepicture/$image
     */
    public function updateProfilePicture($id_user = null, $image = null, $data) {
		try {
			global $con;
			// Update password
			$sql = 	"UPDATE users ".
					"SET image = \"".$image."\" ".
					"WHERE id_user = ".$id_user.";";
			$stmt = $con->exec($sql);
			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
	 * @url OPTIONS /companies/users/$id_user/profilepicture/$image
     */
    public function optionsUnusedMethods($id = null, $data) { return ""; }

}
?>