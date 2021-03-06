<?php 
/**
 * Dependency
 */
require_once __DIR__.'/../vendor/autoload.php';
$api = new MiniApi\MiniApi();

echo "1. authenticate with WSSE.\n";
$response = $api->post('http://www.google.com', '/user')
	->header('Content-Type','application/json')
	->auth('WSSE')
	->prop('wsse.username', 'example-username')
	->prop('wsse.password', 'example-password')
	->call('{"name":"John"}');
echo $response->debug();

echo "2. authenticate with WSSE in SOAP.\n";
$response = $api->soap('http://www.google.com/?wsdl', 'User.New')
	->auth('WSSE')
	->prop('wsse.namespace', 'http://www.google.com')
	->prop('wsse.username', 'example-username')
	->prop('wsse.password', 'example-password')
	->call(array("name"=>"John"));
echo $response->debug();

?>