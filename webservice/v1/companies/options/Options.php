<?php
class Options {	

 
	
	   /**
     * Add brand in company.
     *
     * @url POST /companies/options/addbrand/$brand
     */
    public function addBrand($brand=null) {
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
     * Add brand in company.
     *
     * @url POST /companies/options/addModal/$modal/idbrand/$id_brand
     */
    public function addModal() {
		try {
			global $con;
		
			$sql = 	"INSERT INTO models (model, id_brand) 
					 VALUES ('".$modal."', ".$id_brand.");";
				 
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
    public function getBrand() {
		try {
			global $con;
		
			$sql = 	"SELECT id_brand, brand
					 FROM brands;";
				 
			$stmt = $con->exec($sql);

			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }

}
?>