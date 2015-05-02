<?php
// Requires database files
require '../connect.php';
require '../RESTServer.php';

// Imports WS classes
require 'about/About.php';
require 'vehicles/Vehicles.php';
require 'vehicle/Vehicle.php';

$server = new RESTServer('debug');
$server->addClass('About');
$server->addClass('Vehicles');
$server->addClass('Vehicle');
$server->handle();
