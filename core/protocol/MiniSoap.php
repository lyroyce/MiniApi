<?php
/**
 * A Soap client based on SoapClient
 * @author yinli
 *
 */
class MiniSoap extends MiniProtocol{
	
	protected function send(MiniRequest $request, MiniResponse $response){
		try {
			$client = new SoapClient($request->endpoint());
			$response_body = $client ->__soapCall($request->method(), $request->body());
			$error = "";
		} catch (Exception $ex) {
			$response_body = '';
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