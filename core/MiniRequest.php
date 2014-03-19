<?php 
class MiniRequest {

	const HEADER_PREFIX = 'header.';
	
	private $api;
	private $propMap;
	private $request_raw;
	
	public function __construct(MiniApi $api) {
		$this->api = $api;
		$this->init();
	}
	
	public function init(){
		$this->propMap = array();
		$this->endpoint('http://localhost');
		$this->method('');
		$this->protocol('POST');
		$this->body('');
	}

	public function protocol($protocol=null){
		return $this->prop('protocol.', $protocol);
	}
	
	public function endpoint($endpoint=null){
		return $this->prop('endpoint.', $endpoint);
	}
	
	public function method($method=null){
		return $this->prop('method.', $method);
	}
	
	public function auth($auth=null){
		return $this->prop('auth.', $auth);
	}

	public function body($body=null){
		if($body===null) return $this->prop('body.', $body);
		// request_raw should be the same as body before actual request being made
		return $this->prop('body.', $body)->request_raw($body);
	}
	
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
	
	public function header($key, $value=null){
		return $this->prop(self::HEADER_PREFIX.$key, $value);
	}
	
	public function prop($key, $value=null){
		if($value===null){
			if(array_key_exists($key, $this->propMap)) return $this->propMap[$key];
			else return null;
		}
		$this->propMap[$key] = $value;
		return $this;
	}

	public function build_url(){
		return $this->endpoint() . $this->method();
	}
	
	public function call($body=null){
		$this->body($body);
		return $this->api->call($this);
	}

	public function request_raw($request_raw=null){
		if($request_raw===null) return $this->request_raw;
		$this->request_raw = $request_raw;
		return $this;
	}
	
	public function debug(){
		$detail = "Request: ".$this->protocol()." ".$this->endpoint().$this->method()."\n";
		$request_raw = $this->request_raw();
		$detail .= "$request_raw\n";
		return $detail;
	}

	public function __toString(){
		return stringify($this->body());
	}
}
?>