<?php
require_once __DIR__.'/../core/MiniApi.php';
$api = new MiniApi();

echo "1. make a HTTP OPTIONS request to check if the API is CORS compliant.\n";
$response = $api->options('http://www.google.com')
	->header('Origin', 'https://www.adobe.com')
	->header('Access-Control-Request-Method', 'POST')
	->call();
echo $response->debug();

?>