<?php

/* ======================================================================== *
 * @filename:		Stocks.php												*
 * @topic:			Stocks 													*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @remarks:		-														*
 *																			*
 * Date       | Developer      | Changes description						*
 * ------------------------------------------------------------------------ *
 * 01/05/2015 | S.KHALID      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/
 
class Stocks {	


    /**
     * Return all parents family.
     *
     * @url GET /companies/stocks/family
     */
    public function getFamily() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT id_family, family 
					FROM family 
					WHERE id_parentfamily='0'";
					
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
     * Return all parents family.
     *
     * @url GET /companies/stocks/getAllInformations/$id_site
     */
    public function getAllInformations($id_site = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT sum(quanty) as total, st.id_part, reference, buyingprice, si.name, pa.designation, pa.brand, pa.comment
					FROM stock st, sites si, companies co, parts pa
					WHERE st.id_site = si.id_site
					AND st.id_site = :id_site
					AND st.id_part = pa.id_part
					AND si.id_company = co.id_company
					GROUP BY reference";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_site', $id_site);
			
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
     * Returns the quantity in stock for a specific reference and site.
     *
     * @url GET /companies/stocks/available/site/$id_site/reference/$id_part
     */
    public function getStockAvailableForRefBySite($id_site = null, $id_part = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT IFNULL(SUM(quanty), 0) as quantitytotal ".
					"FROM stock s, parts p ".
					"WHERE s.id_part = p.id_part ".
					"AND s.id_part = :id_part ".
					"AND id_site = :id_site";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_part', $id_part);
			$stmt->bindParam(':id_site', $id_site);
			
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
     * Description.
     *
     * @url PUT /companies/stocks/updatestock/$quanty/id_stock/$id_stock/$reference/$designation/$driveway/$bay/$position/$rack/$id_part/$locker
     */
    public function updatestock($id_stock = null, $quanty = null, $reference = null, $designation = null, $driveway= null, $bay= null, $position= null, $rack= null, $locker= null ) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"UPDATE stock ".
					"SET quanty=: quanty".
					"SET reference=: reference".
					"SET designation=: designation".
					"SET driveway=: driveway".
					"SET bay=:bay".
					"SET position=: position".
					"SET rack=: rack".
					"SET locker=: locker".
					"WHERE id_stock=: id_stock;";
					
					
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':quanty', $quanty);
			$stmt->bindParam(':reference', $reference);
			$stmt->bindParam(':designation', $designation);
			$stmt->bindParam(':driveway', $driveway);
			$stmt->bindParam(':bay', $bay);
			$stmt->bindParam(':position', $position);
			$stmt->bindParam(':rack', $rack);
			$stmt->bindParam(':locker', $locker);
			$stmt->bindParam(':id_stock', $id_stock);
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
     * Get total of vehicles in one site.
     *
     * @url GET /companies/stocks/getreporting/id_site/$id_site
     */
    public function getvehiculereporting($id_site) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT count(*) as total
					FROM vehicles
					WHERE id_site= : id_site ;";
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(': id_site', $id_site);
			
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
     * Reporting .
     *
     * @url GET /companies/stocks/getstate/id_site/$id_site
     */
    public function getvehiculestate($id_site) {
		try {
			global $con;
				/* Statement declaration */
			$sql="SELECT state, count(ve.id_state) as total
				  FROM vehicles ve, states st 
				  WHERE ve.id_state = st.id_state
				  AND ve.id_site = :id_site
				  GROUP BY ve.id_state
				  HAVING count(st.id_state) ;";
		
					
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_site', $id_site);
			
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
     * Delete from stock.
     *
     * @url DELETE /companies/stocks/deletefromstock/id_stock/$id_stock
     */
    public function deletefromstock($id_stock = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"DELETE FROM stock ".
					 "WHERE id_stock= :id_stock ";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_stock', $id_stock);
					
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
     * Insert transfer product in stock.
     *
     * @url POST /companies/stocks/idtransfert/$idtrans/quanty/$myquanty/idpart/$idpart/driveway/$driveway/bay/$bay/position/$position/rack/$rack/locker/$locker/receiver/$thereceiver/type/$type/measure/$measure/storehouse/$storehouse
     */
    public function TransfertProductInStock($idtrans = null, $idpart = null, $driveway = null, $bay = null, $position = null, $rack = null, $locker=null, $myquanty=null, $thereceiver =null, $type =null, $measure =null, $storehouse=null) {
		try {
			
			global $con;
			/* Statement declaration */
			$sql="INSERT INTO stock (quanty, driveway, bay, position, rack, id_site, id_part, locker, id_typestock, id_measurement, storehouse) 
				  VALUES (:myquanty , :driveway, :bay, :position, :rack, :thereceiver, :idpart, :locker, :type, :measure, :storehouse);
				  
				  Update transfert 
				  SET validationdate = NOW(), validation=1
				  WHERE id_transfert = :idtrans;";
			
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':myquanty', $myquanty);
			$stmt->bindParam(':driveway', $driveway);
			$stmt->bindParam(':bay', $bay);
			$stmt->bindParam(':rack', $rack);
			$stmt->bindParam(':thereceiver', $thereceiver);
			$stmt->bindParam(':idpart', $idpart);
			$stmt->bindParam(':locker', $locker);
			$stmt->bindParam(':type', $type);
			$stmt->bindParam(':measure', $measure);
			$stmt->bindParam(':storehouse', $storehouse);
			$stmt->bindParam(':position', $position);
			$stmt->bindParam(':idtrans', $idtrans);
			
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
     * Return ref.
     *
     * @url GET /companies/stocks/checkref/$ref/company/$id_company
     */
    public function checkref($ref = null, $id_company = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT distinct (reference), pa.id_part 
					FROM parts pa 
					WHERE pa.reference like '".$ref."'
					AND pa.id_company = ".$id_company."";
			
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
     * Return all family by company.
     *
     * @url GET /companies/stocks/sitecompany/$id_company
     */
    public function getsitecompany($id_company = null)  {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT si.name, id_site
					FROM companies co, sites si
					WHERE si.id_company=co.id_company
					AND si.id_company = ".$id_company."";
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
     * Save transfer on transfer table and Update number of transfer product in stock.
     *
     * @url POST /companies/stocks/ref/$ref/quanty/$productnumber/secondsite/$id_site2/idstock/$idstock/type/$type/measure/$measure/title/$title
     */
    public function TransfertProduct($ref = null, $productnumber=null, $id_site2 = null, $idstock = null, $type=null, $measure=null, $title=null) {
		try {
			
			global $con;
			/* Statement declaration */
				
		$sql = 	"INSERT INTO transfert (receiver, id_part, quantity, validation, transferdate, type, measure, title) 
				 VALUES (:id_site2, :ref, :productnumber,'0', NOW(), :type, :measure, :title);
				
				 Update stock st, parts pa 
				 SET st.quanty = (quanty - :productnumber) 
				 WHERE st.id_stock = :idstock;";
				
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':id_site2', $id_site2);
			$stmt->bindParam(':ref', $ref);
			$stmt->bindParam(':productnumber', $productnumber);
			$stmt->bindParam(':type', $type);
			$stmt->bindParam(':measure', $measure);
			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':idstock', $idstock);
			
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
     * Get under family by parent.
     *
     * @url GET /companies/stocks/underfamily/$id_family
     */
    public function getModels($id_family = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM family ".
					"WHERE id_parentfamily = ".$id_family.";";
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
     * Return all products.
     *
     * @url GET /companies/stocks/allproducts
     */
    public function getAllproducts() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT reference, designation, buyingprice, cu.symbol as currency, co.name as company, family, quanty, measurement, driveway, bay, position, rack, si.name as site, ty.typestock, locker
					FROM stock st, parts pa, measurement me, currencies cu, companies co, sites si, typestock ty, family fa
					WHERE st.id_measurement=me.id_measurement 
					AND st.id_site=si.id_site 
					AND st.id_typestock=ty.id_typestock 
					AND st.id_part=pa.id_part 
					AND pa.id_currency=cu.id_currency 
					AND pa.id_company=co.id_company 
					AND pa.id_family=fa.id_family";
			
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
     * Return site products.
     *
     * @url GET /companies/stocks/companyproduct/company/$id_company/idsite/$idsite
     */
    public function getcompanyproduct($id_company=null, $idsite=null) {
	
		try {
			global $con;
			/* Statement declaration */
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
     * Return transfer list.
     *
     * @url GET /companies/stocks/getalltransferts/company/$id_company/title/$title
     */
    public function getalltransferts($id_company=null, $title=null) {
	
			
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT id_transfert, title, transferdate, si.name as receivername, tr.receiver as receiver, quantity, reference, tr.id_part, tr.type as typestock, tr.measure as measurement
					FROM transfert tr, parts pa, typestock ty, measurement me, sites si
					WHERE title like '".$title."'
					AND receiver=si.id_site
					AND pa.id_part = tr.id_part
					AND tr.type = ty.id_typestock
					AND tr.measure = me.id_measurement
					AND tr.validation = 0";
			
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
     * Return site products by company.
     *
     * @url GET /companies/stocks/siteproductbycompany/$id_company
     */
    public function getsiteproductbycompany($id_company = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT reference, designation, buyingprice, cu.symbol as currency, co.name as company, family, quanty, measurement, driveway, bay, position, rack, si.name as site, ty.typestock, locker, pa.brand, pa.comment
					FROM stock st, parts pa, measurement me, currencies cu, companies co, sites si, typestock ty, family fa
					WHERE st.id_measurement=me.id_measurement 
					AND st.id_site=si.id_site 
					AND st.id_typestock=ty.id_typestock 
					AND st.id_part=pa.id_part 
					AND pa.id_currency=cu.id_currency 
					AND pa.id_company=co.id_company 
					AND pa.id_family=fa.id_family 
					AND pa.id_company = ".$id_company.";";
			
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
     * Return site transfer list.
     *
     * @url GET /companies/stocks/gettransferlist/company/$id_company
     */
    public function gettransferlist($id_company=null) {
	
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT count(id_transfert) as total, transferdate, id_transfert, title
					FROM transfert tr, sites si
					WHERE si.id_company = ".$id_company."
					AND si.id_site=tr.receiver
					AND validation = 0
					GROUP BY title
					HAVING count(id_transfert);";
					
			
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
     * Return all history list products.
     *
     * @url GET /companies/stocks/historylist/$title/company/$id_company
     */
    public function gethistory($title = null, $id_company=null) {
		try {
			global $con;
			/* Statement declaration */
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
     * Return site products or all sites products.
     *
     * @url GET /companies/stocks/siteproduct/$id_site/company/$fct_id_company
     */
    public function getsiteproduct($id_site = null, $fct_id_company=null) {
		try {
			global $con;
			/* Statement declaration */
			if($id_site == 0)
			{
				$sql = "SELECT id_stock, reference, designation, buyingprice, cu.symbol as currency, co.name as company, family, quanty, measurement, driveway, bay, position, rack, si.name as site, ty.typestock, locker, pa.brand as brand, pa.comment as comment, st.storehouse as storehouse
						FROM stock st, parts pa, measurement me, currencies cu, companies co, sites si, typestock ty, family fa
						WHERE st.id_measurement=me.id_measurement 
						AND st.id_site=si.id_site 
						AND st.id_typestock=ty.id_typestock 
						AND st.id_part=pa.id_part 
						AND pa.id_currency=cu.id_currency 
						AND pa.id_company=co.id_company 
						AND pa.id_family=fa.id_family 
						AND pa.id_company = ".$fct_id_company.";";
			}
			else {
			
				$sql = "SELECT id_stock, reference, designation, buyingprice, cu.symbol as currency, co.name as company, family, quanty, measurement, driveway, bay, position, rack, si.name as site, ty.typestock, locker,  pa.brand as brand, pa.comment as comment, st.storehouse as storehouse
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
     * Return all under family N1.
     *
     * @url GET /companies/stocks/underfamily
     */
    public function getUnderFamily($id_family = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * 
					FROM family 
					WHERE id_parentfamily in (select id_family from family);";
			
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
     * Return all under family N2.
     *
     * @url GET /companies/stocks/underfamily2
     */
    public function getUnderFamily2() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * 
					FROM family 
					WHERE id_parentfamily IN (SELECT id_family 
											  FROM family);";
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
     * Return all kinds.
     *
     * @url GET /companies/stocks/kinds
     */
    public function getKinds() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * 
					FROM kinds;";
			
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
     * Return all Measurements.
     *
     * @url GET /companies/stocks/measurements
     */
    public function getMeasurement() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * 
					FROM measurement;";
			
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
     * Get other sites after first selection.
     *
     * @url GET /companies/$id_company/site/$id_site/sites2
     */
    public function getSites2($id_company = null, $id_site = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT * 
					FROM sites 
					WHERE id_company = ".$id_company."
					AND id_site <> ".$id_site.";";
			
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
     * Get list of release products by company.
     *
     * @url GET /companies/$id_company/release
     */
    public function getreleaseproduct($id_company = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT * 
					FROM transfert tr, sites si
					WHERE si.id_company = ".$id_company."
					AND tr.validation = 1
					AND tr.receiver=si.id_site;";
			
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
     * Get list of sites by company.
     *
     * @url GET /companies/$id_company/sites
     */
    public function getSites($id_company = null) {
		try {
			global $con;
			/* Statement declaration */
			$sql = 	"SELECT * ".
					"FROM sites ".
					"WHERE id_company = ".$id_company.";";
			
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
     * Return all Currencies.
     *
     * @url GET /companies/stocks/currencies
     */
    public function getCurrencies() {
		try {
			global $con;
			/* Statement declaration */
			$sql = "SELECT * 
					FROM currencies;";
			
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
     * Add product in parts table.
     *
     * @url POST /companies/stocks/addProduct/reference/$reference/designation/$designation/buyingprice/$buyingprice/id_currency/$id_currency/id_company/$id_company/id_family/$id_family/brand/$brand/comment/$comment
     */
    public function addProduct($reference = null, $designation = null, $buyingprice = null, $id_currency=null, $id_company=null, $id_family=null, $brand = null, $comment = null) {
		try {
				global $con;
				/* Statement declaration */
			$sql = 	"INSERT INTO parts (reference, designation, buyingprice, id_currency, id_company, id_family, brand, comment) 
					 VALUES (:reference , :designation, :buyingprice, :id_currency, :id_company, :id_family, :brand, :comment);";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':reference', $reference);
			$stmt->bindParam(':designation', $designation);
			$stmt->bindParam(':buyingprice', $buyingprice);
			$stmt->bindParam(':id_currency', $id_currency);
			$stmt->bindParam(':id_company', $id_company);
			$stmt->bindParam(':id_family', $id_family);
			$stmt->bindParam(':brand', $brand);
			$stmt->bindParam(':comment', $comment);
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
     * Add product in Stock.
     *
     * @url POST /companies/stocks/addinstock/quanty/$quanty/id_measurement/$id_measurement/driveway/$driveway/bay/$bay/position/$position/locker/$locker/rack/$rack/id_site/$id_site/id_typestock/$id_typestock/id_part/$id_part/storehouse/$storehouse
     */
    public function addinstock($quanty=null, $id_measurement=null, $driveway=null, $bay=null, $position=null, $rack=null, $id_site=null, $id_typestock=null, $locker=null, $id_part=null, $storehouse = null) {
		try {
			global $con;
		/* Statement declaration */
			$sql = 	"INSERT INTO stock (quanty, id_measurement, driveway, bay, position, rack, id_typestock, id_site, locker, id_part, storehouse) 
					 VALUES (:quanty, :id_measurement, :driveway, :bay, :position, :rack, :id_typestock, :id_site, :locker, :id_part, :storehouse);";
			
			/* Statement values & execution */
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':quanty', $quanty);
			$stmt->bindParam(':id_measurement', $id_measurement);
			$stmt->bindParam(':driveway', $driveway);
			$stmt->bindParam(':bay', $bay);
			$stmt->bindParam(':position', $position);
			$stmt->bindParam(':rack', $rack);
			$stmt->bindParam(':id_typestock', $id_typestock);
			$stmt->bindParam(':id_site', $id_site);
			$stmt->bindParam(':locker', $locker);
			$stmt->bindParam(':id_part', $id_part);
			$stmt->bindParam(':storehouse', $storehouse);
			
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