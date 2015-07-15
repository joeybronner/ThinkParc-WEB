<?php

/* ======================================================================== *
 * @filename:		OptionsTest.php											*
 * @topic:			OptionsTest 											*
 *																			*
 * @author(s): 		Said KHALID												*
 * @contact(s):		khalidsaid.box@gmail.com								*
 * @remarks:		-														*
 *																			*
 * Date       | Developer      | Changes description						*
 * ------------------------------------------------------------------------ *
 * 09/07/2015 | S.KHALID      | Creation									*
 * ------------------------------------------------------------------------ *
 * JJ/MM/AAAA | ...			   | ...			 							*
 * =========================================================================*/
 
 use GuzzleHttp\Client;

class OptionsTest extends PHPUnit_Framework_TestCase {

   /**
	* @description	: Simple unit test to retrieve all brands.
	* @expected		: Returns all brands.
    */

	 public function testgetbrand()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/options/allbrands');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve all companies.
	* @expected		: Returns all companies.
    */

	 public function testgetcompany()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/options/getcompany');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve all users roles.
	* @expected		: Returns all roles.
    */

	 public function testgetroles()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/options/getroles');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
}	

	
	
	
	
	
	
	
	
	
	
	
	
	
	