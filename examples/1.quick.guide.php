<?php 

require_once __DIR__.'/../core/MiniApi.php';
$api = new MiniApi();

/**
 * Simple
 */
echo "1. send a simple POST request with JSON string as body.\n";
$response = $api->post('http://www.google.com/user')->call('{"name":"John"}');
echo $response->debug();

/**
 * Customized
 */
echo "2 send another customized PUT request with associative array as body.\n";
echo "2.1 build a customized request.\n";
// $request = $api->get('http://www.google.com');
// $request = $api->post('http://www.google.com', '/user/new');
// $request = $api->delete('http://www.google.com', '/user/new')
// 				->body('{"name", "John"}');
$request = $api->put('http://www.google.com', '/user/new')
			->header('Content-Type','application/json')
			->body(array("name"=>"John"));

echo "2.2. output the request.\n";
echo sprintf("Request:\n%s %s%s\n", 
		$request->protocol(), 
		$request->endpoint(), 
		$request->method());
echo json_encode($request->body())."\n";

echo "2.3. send the request and get response.\n";
$response = $request->call();

echo "2.4. output the response.\n";
echo sprintf("Response: %s\n%s\n",
		$response->status_code(),
		$response);
if($response->error()){
	echo sprintf("Error: %s\n", 
		$response->error());
}

?>