<?php
/**
 *
 * A manager class that manages authentication methods
 * @author yinli
 *
 */
class MiniAuthManager extends MiniManager{
	
	public function __construct() {
		parent::__construct('MiniAuth');
	}
	
	protected function get_staff_name(MiniRequest $request){
		return $request->auth();
	}
	
	protected function handle_request(MiniRequest $request, $staff){
		if($staff){
			$staff->auth($request);
		}
		return $request;
	}
}
?>