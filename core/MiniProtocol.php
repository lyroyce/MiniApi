<?php

abstract class MiniProtocol {

	public function call(MiniRequest $request){
		$response = new MiniResponse($request);
		$this->send($request, $response);
		return $response;
	}
	
	protected abstract function send(MiniRequest $request, MiniResponse $response);
}
?>