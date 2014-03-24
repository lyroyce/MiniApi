<?php 
require_once __DIR__.'/MiniAutoloader.php';

/**
 * The main class that helps to make API request
 * @author lyroyce
 * 
 */
class MiniApi {

	private $protocol_manager;
	private $current_request;
	private $last_request;
	private $last_response;

	public function __construct() {
		$this->protocol_manager = new MiniProtocolManager();
		$this->_init_protocol_registration();
	}

	/**
	 * Build a MiniRequest object that represents a HTTP GET request.
	 * The final URL is a concatenation of endpoint and method.
	 * @param string $endpoint API server base URL.
	 * @param string $method API method name.
	 * @return MiniRequest a object representing API request
	 */
	public function get($endpoint, $method=''){
		return $this->request($endpoint, $method, 'GET');
	}

	/**
	 * Build a MiniRequest object that represents a HTTP POST request.
	 * The final URL is a concatenation of endpoint and method.
	 * @param string $endpoint API server base URL.
	 * @param string $method API method name.
	 * @return MiniRequest a object representing API request
	 */
	public function post($endpoint, $method=''){
		return $this->request($endpoint, $method, 'POST');
	}

	/**
	 * Build a MiniRequest object that represents a HTTP PUT request.
	 * The final URL is a concatenation of endpoint and method.
	 * @param string $endpoint API server base URL.
	 * @param string $method API method name.
	 * @return MiniRequest a object representing API request
	 */
	public function put($endpoint, $method=''){
		return $this->request($endpoint, $method, 'PUT');
	}

	/**
	 * Build a MiniRequest object that represents a HTTP DELETE request.
	 * The final URL is a concatenation of endpoint and method.
	 * @param string $endpoint API server base URL.
	 * @param string $method API method name.
	 * @return MiniRequest a object representing API request
	 */
	public function delete($endpoint, $method=''){
		return $this->request($endpoint, $method, 'DELETE');
	}

	/**
	 * Build a MiniRequest object that represents a HTTP OPTIONS request.
	 * The final URL is a concatenation of endpoint and method.
	 * @param string $endpoint API server base URL.
	 * @param string $method API method name.
	 * @return MiniRequest a object representing API request
	 */
	public function options($endpoint, $method=''){
		return $this->request($endpoint, $method, 'OPTIONS');
	}

	/**
	 * Build a MiniRequest object that represents a HTTP HEAD request.
	 * The final URL is a concatenation of endpoint and method.
	 * @param string $endpoint API server base URL.
	 * @param string $method API method name.
	 * @return MiniRequest a object representing API request
	 */
	public function head($endpoint, $method=''){
		return $this->request($endpoint, $method, 'HEAD');
	}

	/**
	 * Build a MiniRequest object that represents a SOAP request.
	 * @param string $endpoint WSDL URL.
	 * @param string $method SOAP method name.
	 * @return MiniRequest a object representing API request
	 */
	public function soap($endpoint, $method){
		return $this->request($endpoint, $method, 'SOAP');
	}
	
	/**
	 * Send API request. 
	 * If no request is specified, the last built request will be sent.
	 * @param MiniRequest $request optional, the API request to be sent
	 * @return MiniResponse a object representing API response
	 */
	public function call(MiniRequest $request=null){
		if($request===null) $request = $this->current_request;

		$this->_before_call($request);
		$response = $this->protocol_manager->handle($request);
		$this->_after_call($response);
		return $response;
	}

	/**
	 * Return last received response
	 * @return MiniResponse a object representing API response
	 */
	public function last_response () {
		return $this->last_response;
	}
	
	/**
	 * Return last sent request
	 * @return MiniRequest a object representing API request
	 */
	public function last_request () {
		return $this->last_request;
	}

	/**
	 * Register handler class for existing or new protocol 
	 * @throws Exception if the specified class is not found
	 */
	public function register_protocol ($protocol, $handler_class) {
		return $this->protocol_manager->register_staff($protocol, $handler_class);;
	}
	
	public function request($endpoint, $method, $protocol){
		$request = new MiniRequest($this);
		$request->protocol($protocol)->endpoint($endpoint)->method($method);
		$this->current_request = $request;
		return $this->current_request;
	}

	private function _before_call(MiniRequest $request){
		$this->last_request = $request;
		$this->last_response = null;
	}

	private function _after_call(MiniResponse $response){
		$this->last_response = $response;
	}
	
	private function _init_protocol_registration(){
		$this->register_protocol('GET', 'MiniHttp');
		$this->register_protocol('POST', 'MiniHttp');
		$this->register_protocol('PUT', 'MiniHttp');
		$this->register_protocol('DELETE', 'MiniHttp');
		$this->register_protocol('OPTIONS', 'MiniHttp');
		$this->register_protocol('HEAD', 'MiniHttp');
		$this->register_protocol('SOAP', 'MiniSoap');
	}
	
}
?>