<?php

/* ======================================================================== *
 * @filename:		VehiclesTest.php										*
 * @topic:			VehiclesTest 											*
 *																			*
 * @author(s): 		Joey BRONNER											*
 * @contact(s):		joeybronner@gmail.com									*
 * @remarks:		-														*
 *																			*
 * Date       | Developer      | Changes description						*
 * ------------------------------------------------------------------------ *
 * 09/07/2015 | J.BRONNER      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/
 
use GuzzleHttp\Client;

class MaintenanceTest extends PHPUnit_Framework_TestCase {
	 
   /**
	* @description	: Simple unit test to get all types of maintenance possible.
	* @expected		: Returns all type of maintenance.
    */
    public function testGetAllTypesOfMaintenance()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/maintenance/typemaintenance');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	 
	 
   /**
	* @description	: Simple unit test to retrieve all free vehicles (not in maintenance).
	* @expected		: Returns all free vehicles.
    */
    public function testGetAllVehiclesNotInMaintenance()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/maintenance/freevehicles');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEquals($decodedResponse[0]['id_vehicle'], '34');
    }
	
   /**
	* @description	: Simple unit test to get all informations about a vehicle maintenance.
	* @expected		: Returns all informations for a specific vehicle maintenance.
    */
    public function testGetAllInformationsForAMaintenanceEmpty()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/maintenance/vehicle/34');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to get the total number of days in maintenance for a specific vehicule.
	* @expected		: Returns the number of days in maintenance.
    */
    public function testGetNumberOfDaysInMaintenanceForAVehicleAsNull()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/maintenance/vehicle/34/daysmaintenance');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEquals($decodedResponse[0]['maintenancedays'], null);
    }
	
   /**
	* @description	: Simple unit test to get all the parts used for a vehicle (for previous maintenances).
	* @expected		: Returns all the parts.
    */
    public function testGetAllPartsUsedToRepairAVehicleAsNull()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/maintenance/vehicle/24/partsused');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEquals($decodedResponse[0]['quantity'], null);
    }
	
   /**
	* @description	: Simple unit test to add a vehicle in maintenance.
	* @expected		: Returns success.
    */
    public function testPostNewVehicleInMaintenance()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->post('webservice/v1/companies/3'.
													'/maintenance'.
													'/vehicle/34'. 						// $vehicle.
																'/start/2015-01-01'. 	// $datestartmaintenance.
																'/end/2015-01-02'. 		// $dateendmaintenance.
																'/type/1'. 				// $typemaintenance.
																'/hours/5'. 			// $numberofhours.
																'/rate/9'. 				// $pricebyhours.
																'/curr/1'. 				// $currency.
																'/commentary/unittest');// $commentary;


		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to get the total number of days in maintenance for a specific vehicule.
	* @expected		: Returns the number of days in maintenance.
    */
    public function testGetNumberOfDaysInMaintenanceForAVehicleAsOneDay()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/maintenance/vehicle/34/daysmaintenance');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEquals($decodedResponse[0]['maintenancedays'], '1');
    }
	
   /**
	* @description	: Simple unit test to get complete history of maintenances for a vehicles.
	* @expected		: Returns an history of all maintenances for a specific vehicle.
    */
    public function testGetHistoryMaintenanceNotEmpty()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/maintenance/vehicle/34/allmaintenances');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to get all the vehicles actually in maintenance state.
	* @expected		: Returns all vehicle actually in maintenance.
    */
    public function testGetAllVehiclesInMaintenanceEmpty()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/maintenance/vehiclesundermaintenance');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEmpty($decodedResponse);
    }
	 
   /**
	* @description	: Simple unit test to delete a global vehicle maintenance.
	* @expected		: Returns success.
    */
	/*
    public function testDeleteMaintenanceForAVehicle()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->delete('webservice/v1/companies/3/maintenance/'.$this->id_maintenance);

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['success'], 'OK');
    }*/


}

?>


