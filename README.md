MiniApi
===============

MiniApi is an object oriented and flexible API client which contains everything you need to interact with web API.

Features
-------
- Support standard HTTP protocols: GET, POST, PUT, DELETE, HEAD, OPTIONS;
- Support SOAP protocol
- Support WSSE authentication

Installation
------

	composer require miniapi/miniapi

Get Started
-------

- Initialization

		$api = new MiniApi\MiniApi();

- Simple GET request

		$api->get('http://www.google.com')->call()->debug();

- Simple POST request

		$api->post('http://www.google.com/user')->call('{"name", "John"}')->debug();
		
- POST with WSSE authentication
		
		$response = $api->post('http://www.google.com', '/user')
			->header('Content-Type','application/json')
			->auth('WSSE')
			->prop('wsse.username', 'example-username')
			->prop('wsse.password', 'example-password')
			->call('{"name":"John"}');
		echo $response->body();

- SOAP with WSSE authentication
		
		$response = $api->soap('http://www.google.com/?wsdl', 'User.New')
			->auth('WSSE')
			->prop('wsse.namespace', 'http://www.google.com')
			->prop('wsse.username', 'example-username')
			->prop('wsse.password', 'example-password')
			->call(array("name"=>"John"));
		echo $response->body();

For more code examples, please refer to [examples](examples).

Interface
-------

Protocol | Interface 
---------|-----------
GET    | `$api->get($endpoint, $method='')`
POST   | `$api->post($endpoint, $method='')`
PUT    | `$api->put($endpoint, $method='')`
DELETE | `$api->delete($endpoint, $method='')`
HEAD   | `$api->head($endpoint, $method='')`
OPTIONS| `$api->options($endpoint, $method='')`
SOAP   | `$api->soap($endpoint, $method)`
User-defined | `$api->request($endpoint, $method, $protocol)`

Each interface above returns a instance of `MiniRequest` which allows you to do customization using chaining methods, as you already see. 

The request will NOT be sent until you use `$api->call()` method which accepts an optional body and returns a instance of `MiniResponse`.

Response Handling
-----
`MiniResponse` contains all detailed information about this API call. Below is an example of response handling.

	if($response->error()){
		echo sprintf("Error: %d %s\n%s", 
			$response->status_code(), 
			$response->error(), 
			$response->response_raw());
	}else{
		echo sprintf("Response: %s\n%s\n%s", 
			$response->body(),
			$response->request_raw(), 
			$response->response_raw());
	}

To save your time, you can also simply use `echo $response->debug()` to print out detailed request and response.

Need More Protocols/Authentications?
-------
If you need to use some protocol/authentication that MiniApi currently doesn't support, you can write and register your own protocol handler to extend MiniApi.

	class MySoapClient extends MiniProtocol{
		protected function init_auth_registration(){}
		protected function send(MiniRequest $request, MiniResponse $response){
			echo "MySoapClient is sending request ...\n";
		}
	}
	$api->register_protocol('SOAP', 'MySoapClient');
	$api->request('http://www.google.com/?wsdl', 'User.New', 'SOAP')->call('{"name":"John"}');
	

	
	
