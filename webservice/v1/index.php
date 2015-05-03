<?php
// Requires database files
require '../connect.php';
require '../RESTServer.php';

// Imports WS classes
require 'about/About.php';
require 'companies/vehicles/Vehicles.php';
require 'news/News.php';

$server = new RESTServer('debug');
$server->addClass('About');
$server->addClass('Vehicle');
$server->addClass('News');
$server->handle();
