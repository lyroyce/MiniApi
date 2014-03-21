<?php 
require_once __DIR__.'/../core/MiniApi.php';
$api = new MiniApi();

echo "1. first build a common request.\n";
$request = $api->post('http://www.google.com', '/user')
	->header('Content-Type','application/json')
	->auth('WSSE')
	->prop('auth.username', 'example-username')
	->prop('auth.password', 'example-password');

echo "2. then customize this request for different needs.\n";
echo $request->header('Origin','http://www.example1.com')->call('{"name", "John"}');
echo $request->header('Origin','http://www.example2.com')->call('{"name", "Kate"}');


?>