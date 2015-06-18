<?php
class Options {	

 
	
	   /**
     * Add brand in company.
     *
     * @url POST /companies/options/addbrand/$brand
     */
    public function addbrand($brand=null) {
		try {
			global $con;
		
			$sql = 	"INSERT INTO brands (brand) 
					 VALUES ('".$brand."');";
				 
			$stmt = $con->exec($sql);

			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
	
	 /**
     * Add site in company.
     *
     * @url POST /companies/options/addsite/name/$name/id_company/$id_company/adress1/$adress1/adress2/$adress2/adress3/$adress3/city/$city/country/$country
     */
    public function addsite($name = null, $id_company = null, $adress1 = null, $adress2 = null, $adress3 = null, $city = null, $country = null) {
		try {
			global $con;
		
			$sql = 	"INSERT INTO sites (name, id_company, adress_ligne1, adress_ligne2, adress_ligne3, city, country) 
					 VALUES ('".$name."', ".$id_company.",'".$adress1."','".$adress2."','".$adress3."','".$city."','".$country."');";
			
			echo $sql;
			$stmt = $con->exec($sql);

			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
	   /**
     * Add model in company.
     *
     * @url POST /companies/options/addmodel/$model/idbrand/$id_brand
     */
    public function addmodel($model = null, $id_brand = null) {
		try {
			global $con;
		
			$sql = 	"INSERT INTO models (model, id_brand) 
					 VALUES ('".$model."', ".$id_brand.");";
				 
			$stmt = $con->exec($sql);

			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
		   /**
     * Add brand in company.
     *
     * @url GET /companies/options/allbrands
     */
    public function getbrand() {
		try {
			global $con;
		
			$sql = 	"SELECT id_brand, brand
					 FROM brands;";
				 
			$stmt = $con->query($sql);
			$res = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $res;
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
	
	
		   /**
     * GET company name.
     *
     * @url GET /companies/options/getcompany
     */
    public function getcompany() {
		try {
			global $con;
		
			$sql = 	"SELECT id_company, name
					 FROM companies;";
				 
			$stmt = $con->query($sql);
			$res = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $res;
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
		
		   /**
     * GET roles name.
     *
     * @url GET /companies/options/getroles
     */
    public function getroles() {
		try {
			global $con;
		
			$sql = 	"SELECT id_role, role
					 FROM roles;";
				 
			$stmt = $con->query($sql);
			$res = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $res;
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
	   /**
     * Add user in company.
     *
     * @url POST /companies/options/adduser/$firstname/lastname/$lastname/login/$login/password/$password/email/$email/image/$image/id_role/$id_role/id_company/$id_company
     */
    public function adduser($firstname=null, $lastname=null, $login=null, $password=null, $email=null, $image=null, $id_role=null, $id_company=null) {
		try {
			global $con;
		
			$sql = 	"INSERT INTO users (firstname, lastname, login, pass, email, image, id_role, id_company) 
					 VALUES ('".$firstname."', '".$lastname."', '".$login."', '".$password."', '".$email."', '".$image."', ".$id_role.", ".$id_company.");";
				 
		
			$stmt = $con->exec($sql);

			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }

}
?>