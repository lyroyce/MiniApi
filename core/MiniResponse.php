<?php 
class MiniResponse {

	private $miniRequest;
	private $response;
	private $response_raw;
	private $error;

	public function __construct(MiniRequest $miniRequest) {
		$this->miniRequest = $miniRequest;
	}
	
	public function response_raw($response_raw=null){
		if($response_raw===null) return $this->response_raw;
		$this->response_raw = $response_raw;
		return $this;
	}

	public function response($response=null){
		if($response===null) return $this->response;
		$this->response = $response;
		return $this;
	}

	public function error($error=null){
		if($error===null) return $this->error;
		$this->error = $error;
		return $this;
	}
	
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
	
	public function __toString(){
		return stringify($this->response());
	}
	
}
?>