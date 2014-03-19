<?php 
require_once __DIR__.'/MiniAutoloader.php';

class MiniApi {

	private $protocol_manager;
	private $auth_manager;
	private $current_request;
	private $last_request;
	private $last_response;

	public function __construct() {
		$this->current_request = new MiniRequest($this);
		$this->protocol_manager = new MiniProtocolManager();
		$this->auth_manager = new MiniAuthManager();
		$this->_init_protocol();
		$this->_init_auth();
	}
	
	public function get($endpoint, $method=''){
		return $this->_build_request($endpoint, $method, 'GET');
	}

	public function post($endpoint, $method=''){
		return $this->_build_request($endpoint, $method, 'POST');
	}

	public function put($endpoint, $method=''){
		return $this->_build_request($endpoint, $method, 'PUT');
	}
	
	public function delete($endpoint, $method=''){
		return $this->_build_request($endpoint, $method, 'DELETE');
	}

	public function options($endpoint, $method=''){
		return $this->_build_request($endpoint, $method, 'OPTIONS');
	}

	public function head($endpoint, $method=''){
		return $this->_build_request($endpoint, $method, 'HEAD');
	}
	
	public function call(MiniRequest $request=null){
		if($request===null) $request = $this->current_request;

		$this->_before_call($request);
		$request = $this->auth_manager->handle($request);
		$response = $this->protocol_manager->handle($request);
		$this->_after_call($response);
		return $response;
	}

	/**
	 * Return last HTTP response
	 * @return string
	 */
	public function last_response () {
		return $this->last_response;
	}
	/**
	 * Return last HTTP request
	 * @return string
	 */
	public function last_request () {
		return $this->last_request;
	}
	
	public function register_protocol ($protocol, $handler_class) {
		return $this->protocol_manager->register_staff($protocol, $handler_class);;
	}

	public function register_auth ($auth, $handler_class) {
		return $this->auth_manager->register_staff($auth, $handler_class);;
	}
	
	private function _build_request($endpoint, $method, $protocol){
		$this->current_request->init();
		$this->current_request->protocol($protocol)->endpoint($endpoint)->method($method);
		return $this->current_request;
	}

	private function _before_call(MiniRequest $request){
		$this->last_request = $request;
		$this->last_response = null;
	}

	private function _after_call(MiniResponse $response){
		$this->last_response = $response;
	}
	
	private function _init_protocol(){
		$this->register_protocol('GET', 'MiniHttp');
		$this->register_protocol('POST', 'MiniHttp');
		$this->register_protocol('PUT', 'MiniHttp');
		$this->register_protocol('DELETE', 'MiniHttp');
		$this->register_protocol('OPTIONS', 'MiniHttp');
		$this->register_protocol('HEAD', 'MiniHttp');
	}
	private function _init_auth(){
		$this->register_auth('WSSE', 'MiniWSSE');
	}
	
}
?>