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
     * Return all Sites.
     *
     * @url GET /companies/stocks/sites
     */
    public function getSites() {
		try {
			global $con;
			$sql = "SELECT * FROM sites;";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
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
     * @url GET /companies/stocks/addProduct/$reference/$designation/
     */
    public function addProduct($reference = null, $designation = null) {
		try {
			global $con;
			$sql = 	"INSERT INTO parts (reference, designation)".
					"VALUES (".$reference.", ".$designation.", 1);";
			$stmt = $con->exec($sql);
			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }

}
?>