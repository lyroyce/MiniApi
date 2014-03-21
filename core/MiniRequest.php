<?php 
/**
 * This class represents a API request
 * @author yinli
 *
 */
class MiniRequest {

	const HEADER_PREFIX = 'header.';
	
	private $api;
	private $propMap;
	private $request_raw;
	
	/**
	 * constructor
	 * @param MiniApi $api the main API client
	 */
	public function __construct(MiniApi $api) {
		$this->api = $api;
		$this->init();
	}
	
	/**
	 * Get or set request protocol
	 * @param string $protocol optional
	 * @example $request->protocol('POST');
	 * @example $value = $request->protocol();
	 * @return string return this for setter and current value for getter
	 */
	public function protocol($protocol=null){
		return $this->prop('protocol', $protocol);
	}

	/**
	 * Get or set request endpoint
	 * @param string $endpoint optional
	 * @example $request->endpoint('http://www.google.com');
	 * @example $value = $request->endpoint();
	 * @return string return this for setter and current value for getter
	 */
	public function endpoint($endpoint=null){
		return $this->prop('endpoint', $endpoint);
	}

	/**
	 * Get or set request method
	 * @param string $method optional
	 * @example $request->method('/user/new');
	 * @example $value = $request->method();
	 * @return string return this for setter and current value for getter
	 */
	public function method($method=null){
		return $this->prop('method', $method);
	}

	/**
	 * Get or set request authentication
	 * @param string $auth optional
	 * @example $request->auth('WSSE');
	 * @example $value = $request->auth();
	 * @return string return this for setter and current value for getter
	 */
	public function auth($auth=null){
		return $this->prop('auth', $auth);
	}

	/**
	 * Get or set request body
	 * @param mixed $body optional
	 * @example $request->body('{}');
	 * @example $value = $request->body();
	 * @return mixed return this for setter and current value for getter
	 */
	public function body($body=null){
		return $this->prop('body', $body);
	}

	/**
	 * Return request headers as array
	 * @return array
	 */
	public function headers(){
		$headerArray = array();
		foreach ($this->propMap as $k=>$v){
			if(strpos($k, self::HEADER_PREFIX)===0){
				$k = substr($k, strlen(self::HEADER_PREFIX));
				$headerArray[]=$k.': '.$v;
			}
		}
		return $headerArray;
	}

	/**
	 * Get or set request header
	 * @param string $key header name
	 * @param string $value optional, header value
	 * @example $request->header('Content-Type','application/json');
	 * @example $value = $request->header('Content-Type');
	 * @return string return this for setter and current value for getter
	 */
	public function header($key, $value=null){
		return $this->prop(self::HEADER_PREFIX.$key, $value);
	}

	/**
	 * Get or set request properties
	 * @param string $key property name
	 * @param string $value optional, property value
	 * @example $request->prop('auth.username','admin');
	 * @example $value = $request->prop('auth.username');
	 * @return mixed return this for setter and current value for getter
	 */
	public function prop($key, $value=null){
		if($value===null){
			if(array_key_exists($key, $this->propMap)) return $this->propMap[$key];
			else return null;
		}
		$this->propMap[$key] = $value;
		return $this;
	}

	/**
	 * Send API request with the body specified
	 * @param string $body optional, request body
	 * @return MiniResponse a object representing API response
	 */
	public function call($body=null){
		$this->body($body);
		return $this->api->call($this);
	}

	/**
	 * Get or set raw request with headers.
	 * @return string
	 */
	public function request_raw($request_raw=null){
		if($request_raw===null) return $this->request_raw;
		$this->request_raw = $request_raw;
		return $this;
	}
	
	/**
	 * Return a string representation of whole API request
	 * @return string
	 */
	public function debug(){
		$request_raw = $this->request_raw();
		if($request_raw){
			return "Request:\n$request_raw\n";
		}else{
			$body = stringify($this->body());
			$detail = "Request: ".$this->protocol()." ".$this->endpoint()." ".$this->method()."\n";
			$detail .= "$body\n";
			return $detail;
		}
	}

	/**
	 * Return a string representation of request body
	 * @return string
	 */
	public function __toString(){
		return stringify($this->body(), 128);
	}
	
	private function init(){
		$this->propMap = array();
		$this->endpoint('http://localhost');
		$this->method('');
		$this->protocol('POST');
		$this->body('');
	}
	
}
?>