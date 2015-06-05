<?php
class Maintenance {
	
    /**
     * Description.
     *
     * @url GET /companies/$id_company/maintenance/freevehicles
     */
    public function getCompanyFreeVehicles($id_company = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM vehicles v, kinds k, brands b, states s, categories c, equipments e, energies en, models m, sites si, currencies cu ".
					"WHERE v.id_energy = en.id_energy ".
						"AND v.id_model = m.id_model ".
						"AND v.id_kind = k.id_kind ".
						"AND v.id_category = c.id_category ".
						"AND v.id_equipment = e.id_equipment ".
						"AND v.id_state = s.id_state ".
						"AND v.id_currency = cu.id_currency ".
						"AND v.id_site = si.id_site ".
						"AND si.id_company = ".$id_company." ".
						"AND m.id_brand = b.id_brand ".
						"AND v.id_vehicle NOT IN (SELECT id_vehicle FROM maintenance WHERE date_endmaintenance > NOW()) ".
						"AND v.id_vehicle NOT IN (SELECT id_vehicle FROM maintenance WHERE date_endmaintenance = '0000-00-00');";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url GET /companies/maintenance/typemaintenance
     */
    public function getTypeMaintenace() {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM typemaintenance;";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url GET /companies/$id_company/maintenance/stock/$reference/quantity/$quantity
     */
    public function getAvailableStockForReference($id_company = null, $reference = null, $quantity = null) {
		try {
			global $con;
			$sql = 	"SELECT * ".
					"FROM stock s, parts p, sites si, currencies c ".
					"WHERE s.id_part = p.id_part ".
						"AND p.reference = '".$reference."' ".
						"AND s.quanty >= ".$quantity." ".
						"AND s.id_site = si.id_site ".
						"AND p.id_currency = c.id_currency ".
						"AND s.id_site IN (SELECT id_site FROM sites WHERE id_company = ".$id_company.");";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url POST /companies/$id_company/maintenance/vehicle/$id_vehicle/start/$date_startmaintenance/end/$date_endmaintenance/type/$id_typemaintenance/hours/$labour_hours/rate/$labour_hourlyrate/curr/$id_currency/commentary/$commentary
     */
    public function addVehicleInMaintenance($id_company = null, $id_vehicle = null, $date_startmaintenance = null, $date_endmaintenance = null, 
												$id_typemaintenance = null, $labour_hours = null, $labour_hourlyrate = null, $id_currency = null, 
												$commentary = null, $data) {
		try {			
			// Request
			global $con;
			$sql = 	"INSERT INTO maintenance (id_vehicle, date_startmaintenance, date_endmaintenance, ".
												"id_typemaintenance, labour_hours, labour_hourlyrate, ".
												"id_currency, commentary) ".
					"VALUES (".$id_vehicle.", '".$date_startmaintenance."', '".$date_endmaintenance."', ".
								$id_typemaintenance.", ".$labour_hours.", ".$labour_hourlyrate.", ".
								$id_currency.", '".$commentary."');";
								
			// Execute request
			$stmt = $con->exec($sql);
			$id = $con->lastInsertId('id_maintenance');
			return array("id" => "".$id);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url POST /companies/$id_company/maintenance/$id_maintenance/stock/$id_stock/quantity/$quantity
     */
    public function addPartToMaintenance($id_company = null, $id_maintenance = null, $id_stock = null, $quantity = null, $data) {
		try {			
			// Request
			global $con;
			$sql = 	"INSERT INTO partsmaintenance (id_maintenance, id_stock, quantity)".
					"VALUES (".$id_maintenance.", ".$id_stock.", ".$quantity.");";
			// Execute request
			$stmt = $con->exec($sql);
			$id = $con->lastInsertId('id_partsmaintenance');
			return array("id" => "".$id);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
     * @url PUT /companies/$id_company/stock/$id_stock/quantity/$quantity
     */
    public function updateStockAvailableParts($id_company = null, $id_maintenance = null, $id_stock = null, $quantity = null, $data) {
		try {			
			// Request
			global $con;
			$sql = 	"UPDATE stock ".
					"SET quanty = (quanty - ".$quantity.") ".
					"WHERE id_stock = ".$id_stock.";";
			// Execute request
			$stmt = $con->exec($sql);
			return array("success" => "success");
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
	/**
     * Description.
     *
	 * @url OPTIONS /companies/$id_company/stock/$id_stock/quantity/$quantity
     */
    public function optionsUnusedMethods($id = null, $data) { return ""; }
}
?>