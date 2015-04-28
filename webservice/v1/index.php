<?php

require '../RESTServer.php';
require 'TestController.php';

$server = new RESTServer('debug');
$server->addClass('TestController');
$server->handle();
