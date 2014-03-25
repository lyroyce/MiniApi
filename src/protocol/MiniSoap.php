<?php
/**
 * A Soap client based on SoapClient
 * @author yinli
 *
 */
class MiniSoap extends MiniProtocol{

	protected function init_auth_registration(){
		$this->register_auth('WSSE', 'MiniWsse');
	}
	
	protected function send(MiniRequest $request, MiniResponse $response){
		try {
			$client = new SoapClient($request->endpoint(), array('trace'=>true));
		} catch (Exception $ex) {
			$response->error($ex->__toString());
			return;
		}
		try {
			$headers = array($request->header('X-WSSE'));
			$arguments = $request->body();
			$arguments = is_array($arguments)?$arguments:json_decode($arguments,true);
			$response_body = $client ->__soapCall($request->method(), $arguments, array(), $headers);
			$error = "";
		} catch (Exception $ex) {
			$response_body = null;
			$error = $ex->__toString();
		}
		$request_header = $client->__getLastRequestHeaders();
		$request_raw = $request_header . $client->__getLastRequest();
		$response_header = $client->__getLastResponseHeaders();
		$response_raw = $response_header . $client->__getLastResponse();
		
		$response->body($response_body);
		$response->request_header($request_header);
		$response->request_raw($request_raw);
		$response->response_header($response_header);
		$response->response_raw($response_raw);
		$response->error($error);
	}
	
}
?>