<?php

$ch = curl_init();

//echo ("https://api.copernica.com/database/$databaseID/profiles/?$url").PHP_EOL;

curl_setopt($ch, CURLOPT_URL, "http://think-parc.com/webservice/v1/news/2/status/2");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // note the PUT here

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HEADER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string)                                                                       
));       

// execute the request

$output = curl_exec($ch);

// output the profile information - includes the header
 
echo($output) . PHP_EOL;

// close curl resource to free up system resources

curl_close($ch);