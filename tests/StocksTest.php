<?php

/* ======================================================================== *
 * @filename:		StocksTest.php											*
 * @topic:			StocksTest 												*
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

class StocksTest extends PHPUnit_Framework_TestCase {

   /**
	* @description	: Simple unit test to retrieve all family.
	* @expected		: Returns all family.
    */

	 public function testgetFamily()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/family');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	 /**
	* @description	: Simple unit test to retrieve all products informations.
	* @expected		: Returns all products informations.
    */

	 public function testgetAllInformations()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/getAllInformations/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve a reference in one site.
	* @expected		: Returns the number of available reference.
    */

	 public function testcheckref()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/checkref/Ref123/company/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve all sites of a company.
	* @expected		: Returns the names & ID's of sites.
    */

	 public function testgetsitecompany()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/sitecompany/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	
	/**
	* @description	: Simple unit test to retrieve all products.
	* @expected		: Returns all informations of products.
    */

	 public function testgetAllproducts()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/allproducts');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	
	/**
	* @description	: Simple unit test to retrieve all products on a specific site.
	* @expected		: Returns all informations of products on a specific site.
    */

	 public function testgetcompanyproduct()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/companyproduct/company/1/idsite/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve all transfers.
	* @expected		: Returns all informations of all transfers.
    */

	 public function testgetalltransferts()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/getalltransferts/company/1/title/Sans titre');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	
	/**
	* @description	: Simple unit test to retrieve all products by company.
	* @expected		: Returns all informations of all products by company.
    */

	 public function testgetsiteproductbycompany()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/gettransferlist/company/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve all transfers by company.
	* @expected		: Returns all informations of all transfers by company.
    */

	 public function testgettransferlist()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/siteproductbycompany/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve all history by company.
	* @expected		: Returns all informations of all history by company.
    */

	 public function testgethistory()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/historylist/test 1/company/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve site products or all sites products.
	* @expected		: Returns all informations of products.
    */

	 public function testgetsiteproduct()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/siteproduct/1/company/1');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve all under families.
	* @expected		: Returns the names of under families.
    */

	 public function testgetUnderFamily()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/underfamily');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }

	
	/**
	* @description	: Simple unit test to retrieve all under families N2.
	* @expected		: Returns the names of under families N2.
    */

	 public function testgetUnderFamily2()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/underfamily2');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	
	/**
	* @description	: Simple unit test to retrieve all kinds of products.
	* @expected		: Returns names of kinds.
    */

	 public function testgetKinds()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/kinds');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve all measures.
	* @expected		: Returns names of measures.
    */

	 public function testgetMeasurement()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/measurements');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	
	/**
	* @description	: Simple unit test to retrieve other sites after first selection.
	* @expected		: Returns names of sites & all informations of this site.
    */

	 public function testgetSites2()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/1/site/1/sites2');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	
	/**
	* @description	: Simple unit test to retrieve list of release products by company.
	* @expected		: Returns all informations of this release products.
    */

	 public function testgetreleaseproduct()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/1/release');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve list of sites.
	* @expected		: Returns all informations of these sites.
    */

	 public function testgetSites()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/1/sites');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
	
	/**
	* @description	: Simple unit test to retrieve list of currencies.
	* @expected		: Returns all informations of these currencies.
    */

	 public function testgetCurrencies()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/stocks/currencies');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertNotEmpty($decodedResponse);
    }
		
}
	
	