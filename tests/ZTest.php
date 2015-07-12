<?php

/* ======================================================================== *
 * @filename:		ZTest.php												*
 * @topic:			ZTest	 												*
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

class ZTest extends PHPUnit_Framework_TestCase {
	
   /**
	* @description	: Cleaning database after tests.
    */
    public function testCleaningDatabaseAfterTests()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/tests/cleaning');

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['success'], 'OK');
    }
}

?>


