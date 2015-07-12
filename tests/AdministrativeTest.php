<?php

/* ======================================================================== *
 * @filename:		AdministrativeTest.php									*
 * @topic:			AdministrativeTest 										*
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

class AdministrativeTest extends PHPUnit_Framework_TestCase {
	
   /**
	* @description	: Simple unit test to get all insurances for a company.
	* @expected		: Returns all insurances.
    */
    public function testGetAllInsurancesEmpty()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/administratives/insurances/all');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to add a news insurance for a company/vehicle.
	* @expected		: Returns new insurance ID.
    */
    public function testPostNewInsurance()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->post('webservice/v1/companies/3'.
													'/administratives'.
													'/insurances/testinsurance'. 	// $name
													'/0314324133'. 					// $phone
													'/test@email.com'. 				// $email
													'/line1'. 						// $address_ligne1
													'/line2'. 						// $address_ligne2
													'/line3'. 						// $address_ligne3
													'/75000'. 						// $zipcode
													'/Paris'. 						// $city
													'/France'); 					// $country

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to get all insurances for a company.
	* @expected		: Returns all insurances.
    */
    public function testGetAllInsurancesNotEmpty()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/administratives/insurances/all');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to get all drivers for a company.
	* @expected		: Returns all drivers.
    */
    public function testGetAllDriversEmpty()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/administratives/vehicles/drivers');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEmpty($decodedResponse);
    }
	 
   /**
	* @description	: Simple unit test to add a new driver for a company (with driving licence number, etc...).
	* @expected		: Returns success with ID.
    */
    public function testPostNewDriver()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->post('webservice/v1/companies/3'.
													'/administratives/vehicles/drivers'.
													'/Unit'. 			// $firstname
													'/Tester'. 			// $lastname
													'/777777'. 			// $nr_drivinglicence
													'/2015-01-01'. 		// $acquisition_drivinglicence
													'/2025-01-01');		// $expire_drivinglicence

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to get all drivers for a company.
	* @expected		: Returns all drivers.
    */
    public function testGetAllDriversNotEmpty()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/3/administratives/vehicles/drivers');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
}

?>


