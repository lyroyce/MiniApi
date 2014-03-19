<?php

class MiniProtocolManager extends MiniManager{

	public function __construct() {
		parent::__construct('MiniProtocol');
	}
	
	public function get_staff_name(MiniRequest $request){
		return $request->protocol();
	}
	
	public function handle_request(MiniRequest $request, $staff){
		return $staff->call($request);
	}
}
?>