<?php

/* ======================================================================== *
 * @filename:		UsersTest.php											*
 * @topic:			UsersTest	 											*
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

class UsersTest extends PHPUnit_Framework_TestCase {
	
   /**
	* @description	: Simple unit test to change a password.
	* @expected		: Returns success.
    */
    public function testPutNewPassword()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->put('webservice/v1/companies/users/password/update/24/ab4f63f9ac65152575886860dde480a1');

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['success'], 'OK');
    }
	
   /**
	* @description	: Simple unit test to get user's informations.
	* @expected		: Returns all user's informations.
    */
    public function testGetUserInformations()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->get('webservice/v1/companies/users/24');

		// Response processing & assertion
        $decodedResponse = $response->json();
		$this->assertEquals($decodedResponse[0]['id_user'], '24');
    }
	
   /**
	* @description	: Simple unit test to update user's profile picture.
	* @expected		: Returns success.
    */
    public function testPutNewProfilePicture()
    {
		// Client declaration, URL & method
        $client = new Client(['base_url' => 'http://think-parc.com']);
        $response = $client->put('webservice/v1/companies/users/24/profilepicture/user.png');

		// Response processing & assertion
        $decodedResponse = $response->json();
        $this->assertEquals($decodedResponse['success'], 'OK');
    }
}

?>


