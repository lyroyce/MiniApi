MiniApi
===============

If you want a simple & quick way to invoke web API, MiniApi would be your good partner. 

Benefits:
-------

- It's really simple

		require 'core/MiniApi.php';
		$api = new MiniApi();
		$api->post('http://www.google.com/user')->call('{"name", "John"}')
	
- It's easy to read and powerful

		$api->put('http://www.google.com', '/user')
		->header('Content-Type','application/json')
		->auth('WSSE')
		->prop('auth.username', 'example-username')
		->prop('auth.password', 'example-password')
		->call('{"name":"Locke"}');
	
- It's object oriented and flexible.
	
		$request = $api->get('http://www.google.com');
		echo $request->protocol() . ' ' . $request->endpoint() . $request->method() . "\n";
		echo $request->body() . "\n";
		
		$response = $request->call();
		echo $response;
		if($response->error()){
			echo "Error:\n";
			echo $response->error();
		}
	
- It's highly extendable.

		$api->register_protocol('SOAP', 'MySoapClient');
		$api->register_auth('OAuth', 'MyOAuthHandler');
	
Examples
-------
Please refer to [examples](examples).
	
	