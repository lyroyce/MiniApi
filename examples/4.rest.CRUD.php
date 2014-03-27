<?php 
/**
 * Dependency
 */
require_once __DIR__.'/../vendor/autoload.php';
$api = new MiniApi\MiniApi();

echo "1. make a simple GET request, and output response body.\n";
$response = $api->get('http://www.google.com')->call();
echo $response;

echo "2. make a simple POST request, and output raw response.\n";
$response = $api->post('http://www.google.com', '/user')->header('Content-Type','application/json')->call('{"name", "John"}');
echo $response->debug(false);

echo "3. make a simple PUT request, and output raw request & response.\n";
$response = $api->put('http://www.google.com', '/user')->header('Content-Type','application/json')->call('{"name", "Locke"}');
echo $response->debug();

echo "4. make a simple DELETE request in another flexible way.\n";
$request = $api->delete('http://www.google.com', '/user')->header('Content-Type','application/json')->body('{"name", "Locke"}');
echo "Request:\n";
echo $request->protocol().' '.$request->endpoint().$request->method()."\n";
echo $request->body()."\n";

$response = $request->call();
if($response->error()){
	echo "Error:\n" ;
	echo $response->error()."\n";
}else{
	echo "Response:\n";
	echo $response->body()."\n";
}
?>