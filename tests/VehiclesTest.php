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

class VehiclesTest extends PHPUnit_Framework_TestCase {
	
   /**
	* @description	: Simple unit test to retrieve all brands.
	* @expected		: Returns all brands.
    */
    public function testGetAllBrands()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/vehicles/brands');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all models.
	* @expected		: Returns all models.
    */
    public function testGetAllModels()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/vehicles/models/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all kinds.
	* @expected		: Returns all kinds.
    */
    public function testGetAllKinds()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/vehicles/kinds');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all categories.
	* @expected		: Returns all categories.
    */
    public function testGetAllCategories()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/vehicles/categories');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all energies.
	* @expected		: Returns all energies.
    */
    public function testGetAllEnergies()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/vehicles/energies');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all sites.
	* @expected		: Returns all sites.
    */
    public function testGetAllSites()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/sites');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all states.
	* @expected		: Returns all states.
    */
    public function testGetAllStates()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/vehicles/states');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }	
	
   /**
	* @description	: Simple unit test to retrieve all vehicles for a company.
	* @expected		: Returns all vehicles.
    */
    public function testGetAllVehicles()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/vehicles/all');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all files for a company.
	* @expected		: Returns all files for a company.
    */
    public function testGetAllCompanysFile()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/vehicles/34/files');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all specific vehicle informations.
	* @expected		: Returns all informations for a specific vehicle.
    */
    public function testGetAllInformationsForAVehicles()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/vehicles/34');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEquals($decodedResponse[0]['id_vehicle'], '34');
		$this->assertEquals($decodedResponse[0]['nr_plate'], '000');
		$this->assertEquals($decodedResponse[0]['nr_serial'], '000');
		$this->assertEquals($decodedResponse[0]['mileage'], '100');
		$this->assertEquals($decodedResponse[0]['buyingprice'], '100');
		$this->assertEquals($decodedResponse[0]['date_buy'], '2015-07-01');
		$this->assertEquals($decodedResponse[0]['date_add'], '2015-07-12');
		$this->assertEquals($decodedResponse[0]['date_entryservice'], '2015-07-01');
		$this->assertEquals($decodedResponse[0]['id_energy'], '2');
		$this->assertEquals($decodedResponse[0]['id_model'], '1');
		$this->assertEquals($decodedResponse[0]['id_kind'], '1');
		$this->assertEquals($decodedResponse[0]['id_category'], '1');
		$this->assertEquals($decodedResponse[0]['equipments'], 'test');
		$this->assertEquals($decodedResponse[0]['id_state'], '1');
		$this->assertEquals($decodedResponse[0]['id_site'], '8');
		$this->assertEquals($decodedResponse[0]['id_currency'], '1');
    }
	
   /**
	* @description	: Simple unit test to add a new vehicle for a company.
	* @expected		: Returns success.
    */
    public function testPostNewVehicle()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->post('webservice/v1/companies'.
													'/sites/8'.
													'/vehicles/111'. 			// $nr_plate.
																'/111'. 		// $nr_serial.
																'/100'. 		// $mileage.
																'/10'. 			// $buyingprice.
																'/2015-01-01'. 	// $date_buy.
																'/2015-01-01'. 	// $date_entryservice.
																'/1'. 			// $id_energy.
																'/1'. 			// $id_model.
																'/1'. 			// $id_kind.
																'/1'. 			// $id_category.
																'/equipment'. 	// $equipments.
																'/1'. 			// $id_state.
																'/1'. 			// $id_currency.
																'/unittesttodelete'); // $commentary);

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['success'], 'OK');
    }
	
   /**
	* @description	: Simple unit test to udate vehicle values.
	* @expected		: Returns success.
    */
    public function testUpdateNewVehicle()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->put('webservice/v1/companies'.
													'/sites/8'.
													'/vehicles/111'. 			// $nr_plate.
																'/111'. 		// $nr_serial.
																'/100'. 		// $mileage.
																'/10'. 			// $buyingprice.
																'/2015-01-01'. 	// $date_buy.
																'/2015-01-01'. 	// $date_entryservice.
																'/1'. 			// $id_energy.
																'/1'. 			// $id_model.
																'/1'. 			// $id_kind.
																'/1'. 			// $id_category.
																'/newequipment'.// $equipments.
																'/1'. 			// $id_state.
																'/1'. 			// $id_currency.
																'/unittesttodelete'); // $commentary);

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['success'], 'OK');
    }
}

?>


