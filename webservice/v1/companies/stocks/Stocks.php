<?php
class Stocks {	

    /**
     * Return all parents family.
     *
     * @url GET /companies/stocks/family
     */
    public function getFamily() {
		try {
			global $con;
			$sql = "SELECT id_family, family 
					FROM family 
					WHERE id_parentfamily='0'";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	/**
     * Insert transfer product in stock.
     *
     * @url POST /companies/stocks/idtransfert/$idtrans/quanty/$myquanty/idpart/$idpart/driveway/$driveway/bay/$bay/position/$position/rack/$rack/locker/$locker/receiver/$thereceiver/type/$type/measure/$measure
     */
    public function TransfertProductInStock($idtrans = null, $idpart = null, $driveway = null, $bay = null, $position = null, $rack = null, $locker=null, $myquanty=null, $thereceiver =null, $type =null, $measure =null) {
		try {
			
			global $con;
			
			$sql="INSERT INTO stock (quanty, driveway, bay, position, rack, id_site, id_part, locker, id_typestock, id_measurement) 
				  VALUES ('".$myquanty."' , '".$driveway."','".$bay."','".$position."','".$rack."','".$thereceiver."','".$idpart."','".$locker."','".$type."','".$measure."');
				  
				  Update transfert 
				  SET validationdate = NOW(), validation=1
				  WHERE id_transfert = '".$idtrans."';";
			
			
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
     * @url GET /companies/stocks/checkref/$ref/company/$id_company
     */
    public function checkref($ref = null, $id_company = null) {
		try {
			global $con;
			$sql = "SELECT distinct (reference), pa.id_part 
					FROM parts pa 
					WHERE pa.reference like '".$ref."'
					AND pa.id_company = ".$id_company."";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	 /**
     * Return all family by company.
     *
     * @url GET /companies/stocks/sitecompany/$id_company
     */
    public function getsitecompany($id_company = null)  {
		try {
			global $con;
			$sql = "SELECT si.name, id_site
					FROM companies co, sites si
					WHERE si.id_company=co.id_company
					AND si.id_company = ".$id_company."";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	
	
	 /**
     * Save transfer on transfer table and Update number of transfer product in stock.
     *
     * @url POST /companies/stocks/ref/$ref/quanty/$productnumber/secondsite/$id_site2/idstock/$idstock/type/$type/measure/$measure/title/$title
     */
    public function TransfertProduct($ref = null, $productnumber=null, $id_site2 = null, $idstock = null, $type=null, $measure=null, $title=null) {
		try {
			
			global $con;
			
				
		$sql = 	"INSERT INTO transfert (receiver, id_part, quantity, validation, transferdate, type, measure, title) 
				 VALUES ('".$id_site2."' , '".$ref."','".$productnumber."','0', NOW(), '".$type."','".$measure."','".$title."');
				
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
     * Get under family by parent.
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
     * Return all products.
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
     * Return site products.
     *
     * @url GET /companies/stocks/companyproduct/company/$id_company/idsite/$idsite
     */
    public function getcompanyproduct($id_company=null, $idsite=null) {
	
			
			
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
					AND st.id_site = ".$idsite."";
			
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	 /**
     * Return transfer list.
     *
     * @url GET /companies/stocks/getalltransferts/company/$id_company/title/$title
     */
    public function getalltransferts($id_company=null, $title=null) {
	
			
			
		try {
			global $con;
			$sql = "SELECT id_transfert, title, transferdate, si.name as receivername, tr.receiver as receiver, quantity, reference, tr.id_part, tr.type as typestock, tr.measure as measurement
					FROM transfert tr, parts pa, typestock ty, measurement me, sites si
					WHERE title like '".$title."'
					AND receiver=si.id_site
					AND pa.id_part = tr.id_part
					AND tr.type = ty.id_typestock
					AND tr.measure = me.id_measurement
					AND tr.validation = 0";
			
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	 /**
     * Return site products by company.
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
     * Return site transfer list.
     *
     * @url GET /companies/stocks/gettransferlist/company/$id_company
     */
    public function gettransferlist($id_company=null) {
	
			
		try {
			global $con;
			$sql = "SELECT count(id_transfert) as total, transferdate, id_transfert, title
					FROM transfert tr, sites si
					WHERE si.id_company = ".$id_company."
					AND si.id_site=tr.receiver
					AND validation = 0
					GROUP BY title
					HAVING count(id_transfert);";
					
			
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
		 /**
     * Return all history list products.
     *
     * @url GET /companies/stocks/historylist/$title/company/$id_company
     */
    public function gethistory($title = null, $id_company=null) {
		try {
			global $con;
			
				if($title == "all")
				{
				$sql = "SELECT transferdate, id_transfert, receiver, title, quantity, validationdate, si.name as companyname, reference
						FROM transfert tr, sites si, parts pa
						WHERE tr.validation = 1
						AND receiver = si.id_site
						AND tr.id_part = pa.id_part
						AND tr.receiver=si.id_site
						AND si.id_company = '".$id_company."';";
				} else
				{
			
				$sql = "SELECT transferdate, id_transfert, receiver, title, quantity, validationdate, si.name as companyname, tr.id_part, reference
						FROM transfert tr, sites si, parts pa
						WHERE tr.validation = 1
						AND tr.id_part= pa.id_part
						AND receiver = si.id_site
						AND tr.receiver=si.id_site
						AND tr.title like '".$title."';";
				}
			
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	
	
		 /**
     * Return site products or all sites products.
     *
     * @url GET /companies/stocks/siteproduct/$id_site/company/$id_company
     */
    public function getsiteproduct($id_site = null, $id_company=null) {
		try {
			global $con;
			
			if($id_site==0)
			{
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
			}
			else {
			
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
			}
			
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
			$sql = "SELECT * 
					FROM family 
					WHERE id_parentfamily in (select id_family from family);";
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
			$sql = "SELECT * 
					FROM family 
					WHERE id_parentfamily IN (SELECT id_family 
											  FROM family);";
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
			$sql = "SELECT * 
					FROM kinds;";
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
			$sql = "SELECT * 
					FROM measurement;";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
		/**
     * Get other sites after first selection.
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
     * Get list of release products by company.
     *
     * @url GET /companies/$id_company/release
     */
    public function getreleaseproduct($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * 
					FROM transfert tr, sites si
					WHERE si.id_company = ".$id_company."
					AND tr.validation = 1
					AND tr.receiver=si.id_site;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	
		/**
     * Get list of sites by company.
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
			$sql = "SELECT * 
					FROM currencies;";
			$stmt = $con->query($sql);
			$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $wines;
			
		} catch(PDOException $e) {
			return array("test" => "".$e->getMessage());
		}
    }
	
	    /**
     * Add product in parts table.
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
     * Add product in Stock.
     *
     * @url POST /companies/stocks/addinstock/quanty/$quanty/id_measurement/$id_measurement/driveway/$driveway/bay/$bay/position/$position/locker/$locker/rack/$rack/id_site/$id_site/id_typestock/$id_typestock/id_part/$id_part
     */
    public function addinstock($quanty=null, $id_measurement=null, $driveway=null, $bay=null, $position=null, $rack=null, $id_site=null, $id_typestock=null, $locker=null, $id_part=null) {
		try {
			global $con;
		
			$sql = 	"INSERT INTO stock (quanty, id_measurement, driveway, bay, position, rack, id_typestock, id_site, locker, id_part) 
					 VALUES (".$quanty.", ".$id_measurement.", '".$driveway."', '".$bay."', '".$position."', '".$rack."', ".$id_typestock.", ".$id_site.", '".$locker."', ".$id_part.");";
			$stmt = $con->exec($sql);

			return array("success" => "OK");
		} catch(PDOException $e) {
			return array("error" => "".$e->getMessage());
		}
    }

}
?>