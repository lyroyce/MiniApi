<?php
/**
 * A HTTP client based on CURL
 * @author yinli
 *
 */
class MiniHttp extends MiniProtocol{
	
	protected function init_auth_registration(){
		$this->register_auth('WSSE', 'MiniWsse');
	}
	
	protected function send(MiniRequest $request, MiniResponse $response){
		$ch = $this->prepare_curl($request);
		$response_raw = curl_exec($ch);
		
		$request_header = curl_getinfo($ch, CURLINFO_HEADER_OUT);
		$request_raw = $request_header . stringify($request->body());
		
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$response_header = substr($response_raw, 0, $header_size);
		$response_body = substr($response_raw, $header_size);
		$error = curl_error($ch);
		
		$response->infoMap(curl_getinfo($ch));
		$response->body($response_body);
		$response->request_header($request_header);
		$response->request_raw($request_raw);
		$response->response_header($response_header);
		$response->response_raw($response_raw);
		$response->error($error);
		
		curl_close($ch);
	}
	
	private function prepare_curl(MiniRequest $request){
		$ch = curl_init();
		
		$options = $this->get_curl_options();
		$options[CURLOPT_URL] = $request->endpoint() . $request->method();
		$options[CURLOPT_HTTPHEADER] = $request->headers();
		$options[CURLOPT_CUSTOMREQUEST] = $request->protocol();
		if($this->is_method_with_body($request->protocol())){
			$body = $request->body();
			$options[CURLOPT_POSTFIELDS] = json_encode($body);
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