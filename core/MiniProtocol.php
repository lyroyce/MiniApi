<?php
/**
 * Extend this class to enable more protocols
 * @author yinli
 *
 */
abstract class MiniProtocol {

	/**
	 * Send the API request
	 * @param MiniRequest $request a object representing API request
	 * @return MiniResponse a object representing API response
	 */
	public function call(MiniRequest $request){
		$response = new MiniResponse($request);
		$this->before_send($request, $response);
		$this->send($request, $response);
		$this->after_send($request, $response);
		return $response;
	}

	/**
	 * Do things that need to be done before sending request
	 * @param MiniRequest $request a object representing API request
	 * @param MiniResponse $response a object representing API response
	 */
	protected function before_send(MiniRequest $request, MiniResponse $response){
		// request_raw should be the same as body before actual request being made
		// request body could be an array
		$request->request_raw(stringify($request->body()));
	}
	
	/**
	 * Send the API request and update response object with actual API response
	 * @param MiniRequest $request a object representing API request
	 * @param MiniResponse $response a object representing API response
	 */
	protected abstract function send(MiniRequest $request, MiniResponse $response);
	

	/**
	 * Do things that need to be done after sending request
	 * @param MiniRequest $request a object representing API request
	 * @param MiniResponse $response a object representing API response
	 */
	protected function after_send(MiniRequest $request, MiniResponse $response){
		$request_header = $response->request_header();
		if($request_header!==null){
			// actual request body may differ
			$request->request_raw($request_header . stringify($request->body()));
		}
	}
	
}
?>