<?php 
/**
 * Dependency
 */
require_once __DIR__.'/../vendor/autoload.php';
$api = new MiniApi\MiniApi();

echo "1. first build a common request.\n";
$request = $api->post('http://www.google.com', '/user')
	->header('Content-Type','application/json')
	->auth('WSSE')
	->prop('wsse.username', 'example-username')
	->prop('wsse.password', 'example-password');

echo "2. then customize this request for different needs.\n";
echo $request->header('Origin','http://www.example1.com')->call('{"name", "John"}');
echo $request->header('Origin','http://www.example2.com')->call('{"name", "Kate"}');


?>