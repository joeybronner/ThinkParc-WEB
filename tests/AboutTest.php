<?php

/* ======================================================================== *
 * @filename:		AboutTest.php											*
 * @topic:			AboutTest 												*
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

class AboutTest extends PHPUnit_Framework_TestCase {
	
   /**
	* @description	: Simple unit test to retrieve software name and version.
	* @expected		: Returns the software name and version.
    */
    public function testGetSoftwareNameVersion()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/about/software');

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($response->getStatusCode(), 200);
    }
	
   /**
	* @description	: Simple unit test to retrieve developer names.
	* @expected		: Returns developers names.
    */
    public function testGetDevelopers()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/about/developers');

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['developers'], 'Joey BRONNER & Said KHALID');
    }
}

?>


