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
			// Check if older password match with database's password
			
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
	 * @url PUT /companies/users/$id
     */
    public function testPUT($id = null, $data) {
		return array("success" => "PUT");
    }
	
	/**
     * Description.
     *
	 * @url OPTIONS /companies/users/$id
     */
    public function optionsUnusedMethods($id = null, $data) { return ""; }

}
?>