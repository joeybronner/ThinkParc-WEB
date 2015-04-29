<?php
class About
{
    /**
     * Returns the software name and version
     *
     * @url GET /about/software
     */
    public function about() {
		return array("about" => "Think Parc Software Web Service");
    }
	
    /**
     * Returns developers names
     *
     * @url GET /about/developers
     */
    public function developers() {
		return array("developers" => "Joey BRONNER & Said KHALID");
    }
}