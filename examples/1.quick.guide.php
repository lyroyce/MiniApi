<?php 

require_once __DIR__.'/../core/MiniApi.php';
$api = new MiniApi();

/**
 * Simple
 */
echo "1. send a simple POST request\n";
echo $api->post('http://www.google.com/user')->call('{"name", "John"}');

/**
 * Customized
 */
echo "2 send another customized request\n";
echo "2.1 build a customized post request\n";
// $request = $api->get('http://www.google.com');
// $request = $api->put('http://www.google.com', '/user/new');
// $request = $api->delete('http://www.google.com', '/user/new')->body('{"name", "John"}');
$request = $api->post('http://www.google.com', '/user/new')->body('{"name", "John"}')->header('Content-Type','application/json');

echo "2.2. output the request\n";
echo "Request:\n";
echo $request->protocol() . ' ' . $request->endpoint() . $request->method() . "\n";
echo $request->body() . "\n";

echo "2.3. send the request and get response\n";
$response = $request->call();

echo "2.4. output the response\n";
echo "Response:\n";
echo $response;
if($response->error()){
	echo "Error:\n";
	echo $response->error();
}

?>