<?php

/* ======================================================================== *
 * @filename:		Options.php												*
 * @topic:			Options 												*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @remarks:		-														*
 *																			*
 * Date       | Developer      | Changes description						*
 * ------------------------------------------------------------------------ *
 * 02/06/2015 | S.KHALID      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/

class Options {	

	    /**
     * Add brand in company.
     *
     * @url POST /companies/options/addbrand/$brand
     */
    public function addbrand($brand=null) {
		try {
			global $con;
		/* Statement declaration */
			$sql = 	"INSERT INTO brands(brand) 
					 VALUES (:brand);";
			
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':brand', $brand);
			
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
     * Add site in company.
     *
     * @url POST /companies/options/addsite/name/$name/id_company/$id_company/adress1/$adress1/adress2/$adress2/adress3/$adress3/city/$city/country/$country
     */
    public function addsite($name = null, $id_company = null, $adress1 = null, $adress2 = null, $adress3 = null, $city = null, $country = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO sites (name, id_company, address_ligne1, address_ligne2, address_ligne3, city, country) 
					 VALUES (:name, :id_company, :adress1, :adress2, :adress3, :city , :country);";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':id_company', $id_company);
			$stmt->bindParam(':adress1', $adress1);
			$stmt->bindParam(':adress2', $adress2);
			$stmt->bindParam(':adress3', $adress3);
			$stmt->bindParam(':city', $city);
			$stmt->bindParam(':country', $country);
			
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
     * Add model in company.
     *
     * @url POST /companies/options/addmodel/$model/idbrand/$id_brand
     */
    public function addmodel($model = null, $id_brand = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO models (model, id_brand) 
					 VALUES (:model, :id_brand);";
				 
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':model', $model);
			$stmt->bindParam(':id_brand', $id_brand);
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
     * Add brand in company.
     *
     * @url GET /companies/options/allbrands
     */
    public function getbrand() {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT id_brand, brand
					 FROM brands;";
				 
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			
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
     * GET company name.
     *
     * @url GET /companies/options/getcompany
     */
    public function getcompany() {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT id_company, name
					 FROM companies WHERE id_company<>3;";
				 
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			
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
     * GET roles name.
     *
     * @url GET /companies/options/getroles
     */
    public function getroles() {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT id_role, role
					 FROM roles;";
				 
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			
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
     * Add user in company.
     *
     * @url POST /companies/options/adduser/$firstname/lastname/$lastname/login/$login/password/$password/email/$email/image/$image/id_role/$id_role/id_company/$id_company
     */
    public function adduser($firstname=null, $lastname=null, $login=null, $password=null, $email=null, $image=null, $id_role=null, $id_company=null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"INSERT INTO users (firstname, lastname, login, pass, email, image, id_role, id_company) 
					 VALUES (:firstname, :lastname, :login, :password, :email, :image, :id_role, :id_company);";
				 
		/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':firstname', $firstname);
			$stmt->bindParam(':lastname', $lastname);
			$stmt->bindParam(':login', $login);
			$stmt->bindParam(':password', $password);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':image', $image);
			$stmt->bindParam(':id_role', $id_role);
			$stmt->bindParam(':id_company', $id_company);
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

}
?>