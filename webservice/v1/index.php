<?php
// Requires database files
require '../connect.php';
require '../RESTServer.php';

// Imports WS classes
require 'about/About.php';
require 'companies/vehicles/Vehicles.php';
require 'news/News.php';
require 'companies/stocks/Stocks.php';
require 'companies/users/Users.php';
require 'companies/administratives/Administratives.php';
require 'files/Files.php';
require 'companies/Company.php';
require 'companies/maintenance/Maintenance.php';
require 'companies/reporting/Reporting.php';
require 'companies/options/Options.php';

$server = new RESTServer('debug');
$server->addClass('About');
$server->addClass('Vehicle');
$server->addClass('News');
$server->addClass('Stocks');
$server->addClass('Users');
$server->addClass('Administratives');
$server->addClass('Files');
$server->addClass('Company');
$server->addClass('Maintenance');
$server->addClass('Reporting');
$server->addClass('Options');
$server->handle();
