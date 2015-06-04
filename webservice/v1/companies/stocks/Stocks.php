<?php
class Stocks {	

    /**
     * Return all family.
     *
     * @url GET /companies/stocks/family
     */
    public function getFamily() {
		try {
			global $con;
			$sql = "SELECT id_family, family FROM family WHERE id_parentfamily='0'";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	
	 /**
     * Insert on transfert.
     *
     * @url POST /companies/stocks/ref/$ref/quanty/$productnumber/secondsite/$id_site2/idstock/$idstock
     */
    public function TransfertProduct($ref = null, $productnumber=null, $id_site2 = null, $idstock = null) {
		try {
			
			global $con;
			
				
		$sql = 	"INSERT INTO transfert (receiver, id_part, quantity, validation) 
				VALUES ('".$id_site2."' , '".$ref."','".$productnumber."','0');
				
				Update stock st, parts pa 
				SET st.quanty = (quanty - '".$productnumber."') 
				WHERE st.id_stock = '".$idstock."';";
				
			echo $sql;
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
		
		
    }
	
	
	  /**
     * .
     *
     * @url GET /companies/stocks/nbproduct/$id_stock
     */
    public function getnbproduct($id_stock = null) {
		try {
			global $con;
			$sql = 	"Select distinct quanty as quanty
					 FROM parts pa, stock st, sites si, companies co 
					 WHERE st.id_part=pa.id_part 
					 AND si.id_company=co.id_company
					 AND pa.id_company=co.id_company
					 AND st.id_stock=".$id_stock.";";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	
	   /**
     * Description
     *
     * @url GET /companies/stocks/underfamily/$id_family
     */
    public function getModels($id_family = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM family ".
					"WHERE id_parentfamily = ".$id_family.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	
	
	
	  /**
     * Return all family.
     *
     * @url GET /companies/stocks/allproducts
     */
    public function getAllproducts() {
		try {
			global $con;
			$sql = "SELECT reference, designation, buyingprice, cu.symbol as currency, co.name as company, family, quanty, measurement, driveway, bay, position, rack, si.name as site, ty.typestock, locker
			FROM stock st, parts pa, measurement me, currencies cu, companies co, sites si, typestock ty, family fa
			WHERE st.id_measurement=me.id_measurement 
			AND st.id_site=si.id_site 
			AND st.id_typestock=ty.id_typestock 
			AND st.id_part=pa.id_part 
			AND pa.id_currency=cu.id_currency 
			AND pa.id_company=co.id_company 
			AND pa.id_family=fa.id_family";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
		    /**
     * Return all product by family.
     *
     * @url GET /companies/stocks/displayproductbycompany/$id_company/ref/$ref
     */
    public function getproductbycompany($id_company = null, $ref = null) {
		try {
			global $con;
			$sql = 	"SELECT * 
					FROM parts 
					WHERE id_company = ".$id_company."
					AND reference = ".$ref.";";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	
	    /**
     * Return all family.
     *
     * @url GET /companies/stocks/product
     */
    public function getproduct() {
		try {
			global $con;
			$sql = "SELECT * FROM parts";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
		    /**
     * Return ref.
     *
     * @url GET /companies/stocks/checkref/$ref
     */
    public function checkref($ref = null) {
		try {
			global $con;
			$sql = "SELECT distinct (reference), pa.id_part FROM parts pa, stock st WHERE st.id_part=pa.id_part AND pa.reference='".$ref."'";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
		 /**
     * Return site productbyref.
     *
     * @url GET /companies/stocks/companyproduct/company/$id_company
     */
    public function getcompanyproduct($id_company=null) {
	
			
			
		try {
			global $con;
			$sql = "SELECT reference, st.id_stock, st.id_part, st.id_measurement, st.id_typestock, designation, buyingprice, cu.symbol as currency, co.name as company, family, quanty, measurement, driveway, bay, position, rack, si.name as site, ty.typestock, locker
			FROM stock st, parts pa, measurement me, currencies cu, companies co, sites si, typestock ty, family fa
			WHERE st.id_measurement=me.id_measurement 
			AND st.id_site=si.id_site 
			AND st.id_typestock=ty.id_typestock 
			AND st.id_part=pa.id_part 
			AND pa.id_currency=cu.id_currency 
			AND pa.id_company=co.id_company 
			AND pa.id_family=fa.id_family 
			AND pa.id_company = ".$id_company."
			ORDER BY company;";
			
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	 /**
     * Return site product by company.
     *
     * @url GET /companies/stocks/siteproductbycompany/$id_company
     */
    public function getsiteproductbycompany($id_company = null) {
		try {
			global $con;
			$sql = "SELECT reference, designation, buyingprice, cu.symbol as currency, co.name as company, family, quanty, measurement, driveway, bay, position, rack, si.name as site, ty.typestock, locker
			FROM stock st, parts pa, measurement me, currencies cu, companies co, sites si, typestock ty, family fa
			WHERE st.id_measurement=me.id_measurement 
			AND st.id_site=si.id_site 
			AND st.id_typestock=ty.id_typestock 
			AND st.id_part=pa.id_part 
			AND pa.id_currency=cu.id_currency 
			AND pa.id_company=co.id_company 
			AND pa.id_family=fa.id_family 
			AND pa.id_company = ".$id_company.";";
			
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	
		 /**
     * Return site product.
     *
     * @url GET /companies/stocks/siteproduct/$id_site
     */
    public function getsiteproduct($id_site = null) {
		try {
			global $con;
			$sql = "SELECT reference, designation, buyingprice, cu.symbol as currency, co.name as company, family, quanty, measurement, driveway, bay, position, rack, si.name as site, ty.typestock, locker
			FROM stock st, parts pa, measurement me, currencies cu, companies co, sites si, typestock ty, family fa
			WHERE st.id_measurement=me.id_measurement 
			AND st.id_site=si.id_site 
			AND st.id_typestock=ty.id_typestock 
			AND st.id_part=pa.id_part 
			AND pa.id_currency=cu.id_currency 
			AND pa.id_company=co.id_company 
			AND pa.id_family=fa.id_family 
			AND st.id_site = ".$id_site.";";
			
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	 /**
     * Return all under family N1.
     *
     * @url GET /companies/stocks/underfamily
     */
    public function getUnderFamily($id_family = null) {
		try {
			global $con;
			$sql = "SELECT * FROM family where id_parentfamily in (select id_family from family);";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	 /**
     * Return all under family N2.
     *
     * @url GET /companies/stocks/underfamily2
     */
    public function getUnderFamily2() {
		try {
			global $con;
			$sql = "SELECT * FROM family where id_parentfamily in (select id_family from family);";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	/**
     * Return all kinds.
     *
     * @url GET /companies/stocks/kinds
     */
    public function getKinds() {
		try {
			global $con;
			$sql = "SELECT * FROM kinds;";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
		/**
     * Return all Measurements.
     *
     * @url GET /companies/stocks/measurements
     */
    public function getMeasurement() {
		try {
			global $con;
			$sql = "SELECT * FROM measurement;";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	
	
	
	/**
     * Description
     *
     * @url GET /companies/$id_site/ref/$id_company/company
     */
    public function getprodref($id_site= null, $id_company=null) {
		try {
			global $con;
			$sql = 	"Select distinct st.id_part, st.id_stock, reference FROM parts pa, stock st, sites si, companies co 
					 WHERE st.id_part=pa.id_part 
					 AND si.id_company=co.id_company
					 AND pa.id_company=".$id_company."
					 AND st.id_site=".$id_site."
					 GROUP BY reference
					 HAVING count(reference);";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	
		/**
     * Description
     *
     * @url GET /companies/$id_company/site/$id_site/sites2
     */
    public function getSites2($id_company = null, $id_site = null) {
		try {
			global $con;
			$sql = 	"SELECT * 
					FROM sites 
					WHERE id_company = ".$id_company."
					AND id_site <> ".$id_site.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	
		/**
     * Description
     *
     * @url GET /companies/$id_company/sites
     */
    public function getSites($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM sites ".
					"WHERE id_company = ".$id_company.";";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
		/**
     * Return all Currencies.
     *
     * @url GET /companies/stocks/currencies
     */
    public function getCurrencies() {
		try {
			global $con;
			$sql = "SELECT * FROM currencies;";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	    /**
     * Description.
     *
     * @url POST /companies/stocks/addProduct/reference/$reference/designation/$designation/buyingprice/$buyingprice/id_currency/$id_currency/id_company/$id_company/id_family/$id_family
     */
    public function addProduct($reference = null, $designation = null, $buyingprice = null, $id_currency=null, $id_company=null, $id_family=null) {
		try {
				global $con;
			$sql = 	"INSERT INTO parts (reference, designation, buyingprice, id_currency, id_company, id_family) 
			VALUES ('".$reference."', '".$designation."', ".$buyingprice.", ".$id_currency.", ".$id_company.", ".$id_family.");";
			$stmt = $con->exec($sql);
		
		
			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }
	
	   /**
     * Description.
     *
     * @url POST /companies/stocks/addinstock/quanty/$quanty/id_measurement/$id_measurement/driveway/$driveway/bay/$bay/position/$position/locker/$locker/rack/$rack/id_site/$id_site/id_typestock/$id_typestock/id_part/$id_part
     */
    public function addinstock($quanty=null, $id_measurement=null, $driveway=null, $bay=null, $position=null, $rack=null, $id_site=null, $id_typestock=null, $locker=null, $id_part=null) {
		try {
				global $con;
		
			$sql = 	"INSERT INTO stock (quanty, id_measurement, driveway, bay, position, rack, id_typestock, id_site, locker, id_part) 
			VALUES (".$quanty.", ".$id_measurement.", ".$driveway.", ".$bay.", ".$position.", ".$rack.", ".$id_typestock.", ".$id_site.", ".$locker.", ".$id_part.");";
			$stmt = $con->exec($sql);


			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }

}
?>