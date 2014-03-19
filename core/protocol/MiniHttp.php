<?php

class MiniHttp extends MiniProtocol{
	
	protected function send(MiniRequest $request, MiniResponse $response){
		$ch = $this->prepare_curl($request);
		
		$response_raw = curl_exec($ch);
		
		$request_header = curl_getinfo($ch, CURLINFO_HEADER_OUT );
		$request_raw = $request_header . $request->body();
		
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$response_body = substr($response_raw, $header_size);
		
		$err = curl_error($ch);
		curl_close($ch);
		$request->request_raw($request_raw);
		$response->response($response_body)->response_raw($response_raw)->error($err);
	}
	
	private function prepare_curl(MiniRequest $request){
		$ch = curl_init();
		
		$options = $this->get_curl_options();
		$options[CURLOPT_URL] = $request->build_url();
		$options[CURLOPT_HTTPHEADER] = $request->headers();
		$options[CURLOPT_CUSTOMREQUEST] = $request->protocol();
		if($this->is_method_with_body($request->protocol())){
			$options[CURLOPT_POSTFIELDS] = $request->body();
		}else{
			$request->body("");
		}
		curl_setopt_array($ch, $options);
		return $ch;
	}
	
	private function get_curl_options(){
		$options = array(
				CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
				CURLOPT_RETURNTRANSFER => true,
				CURLINFO_HEADER_OUT => true,
				CURLOPT_HEADER => true,
				CURLOPT_SSL_VERIFYPEER => false
		);
		return $options;
	}
	
	private function is_method_with_body($http_method){
		return !in_array($http_method, array('GET','HEAD','OPTIONS'));
	}

}
?>