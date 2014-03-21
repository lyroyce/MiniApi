<?php 
/**
 * This class represents a API response
 * @author yinli
 *
 */
class MiniResponse {

	private $miniRequest;
	private $infoMap;

	/**
	 * constructor
	 * @param MiniRequest $miniRequest the original request object
	 */
	public function __construct(MiniRequest $miniRequest) {
		$this->miniRequest = $miniRequest;
		$this->infoMap = array();
	}

	/**
	 * Update information regarding this response
	 * @param array $info associative array
	 * @return MiniResponse return this
	 */
	public function infoMap($info){
		$this->infoMap = $info + $this->infoMap;
		return $this;
	}
	
	/**
	 * Get or set information regarding this response
	 * @param string $key property name
	 * @param string $value optional, property value
	 * @return mixed return this for setter and current value for getter
	 */
	public function info($key, $value=null){
		if($value===null){
			if(array_key_exists($key, $this->infoMap)) return $this->infoMap[$key];
			else return null;
		}
		$this->infoMap[$key] = $value;
		return $this;
	}

	/**
	 * Get or set raw request with headers.
	 * @return string
	 */
	public function request_raw($request_raw=null){
		if($request_raw===null) return $this->miniRequest->request_raw();
		$this->miniRequest->request_raw($request_raw);
		return $this;
	}
	
	/**
	 * Get or set raw response with headers.
	 * @param string optional
	 * @return mixed return this for setter and string for getter
	 */
	public function response_raw($response_raw=null){
		return $this->info('response_raw', $response_raw);
	}

	/**
	 * Get or set response body.
	 * @param string optional
	 * @return mixed return this for setter and string for getter
	 */
	public function body($body=null){
		return $this->info('body', $body);
	}

	/**
	 * Get or set response status code.
	 * @param string optional
	 * @return mixed return this for setter and string for getter
	 */
	public function status_code($code=null){
		return $this->info('http_code', $code);
	}

	/**
	 * Get or set request header.
	 * @param string optional
	 * @return mixed return this for setter and string for getter
	 */
	public function request_header($request_header=null){
		return $this->info('request_header', $request_header);
	}

	/**
	 * Get or set response header.
	 * @param string optional
	 * @return mixed return this for setter and string for getter
	 */
	public function response_header($response_header=null){
		return $this->info('response_header', $response_header);
	}
	
	/**
	 * Get or set error message. An empty string is returned if no error occurred.
	 * @param string optional
	 * @return mixed return this for setter and string for getter
	 */
	public function error($error=null){
		return $this->info('error', $error);
	}

	/**
	 * Return a string representation of whole API response
	 * @param bool optional, default to true, set to false to omit request information
	 * @return string
	 */
	public function debug($more=true){
		// include raw request if more is true
		$detail = $more ? $this->miniRequest->debug()."\n" : "";
		// stringify in case the response is a non-string
		$response_raw = stringify($this->response_raw());
		$detail .= "Response:\n$response_raw\n";
		
		$error = $this->error();
		if($error) $detail.="Error: $error\n";
		
		return $detail;
	}

	/**
	 * Return a string representation of response body
	 * @return string
	 */
	public function __toString(){
		return stringify($this->body(), 128);
	}

	/**
	 * Return json decoded response body.
	 * @return mixed
	 * @see json_decode()
	 */
	public function json(){
		$body = $this->body();
		return json_decode($body, true);
	}
	
}
?>