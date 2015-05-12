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
			$sql = "SELECT id_family, family FROM family";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	
	  /**
     * This is a test.
     *
     * @url GET /companies/stocks/montest
     */
    public function getmontest() {
		try {
			global $con;
			$sql = "SELECT reference, designation, buyingprice
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
     * Return site product.
     *
     * @url GET /companies/stocks/siteproduct/$id_site
     */
    public function getsiteproduct($id_site = null) {
		try {
			global $con;
			$sql = "SELECT * FROM stock WHERE id_site = ".$id_site.";";
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