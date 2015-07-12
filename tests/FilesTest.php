<?php

/* ======================================================================== *
 * @filename:		FilesTest.php											*
 * @topic:			FilesTest 												*
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

class FilesTest extends PHPUnit_Framework_TestCase {
	
   /**
	* @description	: Simple unit test to retrieve a file path.
	* @expected		: Returns the file path.
    */
    public function testGetFile()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/files/1/path');

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($response->getStatusCode(), 200);
    }
	
   /**
	* @description	: Simple unit test to add a new file.
	* @expected		: Returns success after insertion.
    */
	public function testPostFile()
	{
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->post('webservice/v1/files/new/0/unittest/0');
		
		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['success'], 'OK');
		
	}

}

?>


