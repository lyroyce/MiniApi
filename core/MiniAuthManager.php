<?php

class MiniAuthManager extends MiniManager{
	
	public function __construct() {
		parent::__construct('MiniAuth');
	}
	
	public function get_staff_name(MiniRequest $request){
		return $request->auth();
	}
	
	public function handle_request(MiniRequest $request, $staff){
		if($staff){
			$staff->auth($request);
		}
		return $request;
	}
}
?>