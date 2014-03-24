MiniApi
===============

MiniApi is a PHP based framework which contains everything you need to interact with web API.

Benefits:
-------

- It's really simple

		require 'core/MiniApi.php';
		$api = new MiniApi();
		$api->post('http://www.google.com/user')->call('{"name", "John"}');
	
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
	
- It's extendable.

		class MySoapClient extends MiniProtocol{
			protected function init_auth_registration(){}
			protected function send(MiniRequest $request, MiniResponse $response){}
		}
		$api->register_protocol('SOAP', 'MySoapClient');
		$api->request('http://www.google.com/?wsdl', 'User.New', 'SOAP')->call('{"name":"John"}');
	
Examples
-------
Please refer to [examples](examples).
	
	