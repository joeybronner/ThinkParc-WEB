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
						"AND v.id_vehicle NOT IN (SELECT id_vehicle FROM maintenance WHERE date_endmaintenance > NOW());";
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
					"FROM stock s, parts p, sites si ".
					"WHERE s.id_part = p.id_part ".
						"AND p.reference = '".$reference."' ".
						"AND s.quanty >= ".$quantity." ".
						"AND s.id_site = si.id_site ".
						"AND s.id_site IN (SELECT id_site FROM sites WHERE id_company = ".$id_company.");";
			$stmt = $con->query($sql);
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			return array("error" => $e->getMessage());
		}
    }
	
}
?>