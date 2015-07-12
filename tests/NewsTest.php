<?php

/* ======================================================================== *
 * @filename:		NewsTest.php											*
 * @topic:			NewsTest 												*
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

class NewsTest extends PHPUnit_Framework_TestCase {
	
   /**
	* @description	: Simple unit test to retrieve randomly a news.
	* @expected		: Returns a news randomly.
    */
    public function testGetRandomNews()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/news/random');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to retrieve all news.
	* @expected		: Returns all news.
    */
    public function testGetAllNews()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/news/all');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
   /**
	* @description	: Simple unit test to delete a news.
	* @expected		: Deletes a news.
    */
    public function testDeleteNews()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/news/0/delete');

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['success'], 'OK');
    }

}

?>


