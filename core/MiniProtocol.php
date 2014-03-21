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
		$this->send($request, $response);
		return $response;
	}

	/**
	 * Send the API request and update response object with actual API response
	 * @param MiniRequest $request a object representing API request
	 * @param MiniResponse $response a object representing API response
	 */
	protected abstract function send(MiniRequest $request, MiniResponse $response);
	
}
?>