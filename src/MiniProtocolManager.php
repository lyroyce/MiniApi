<?php
/**
 *
 * A manager class that manages different protocols
 * @author yinli
 *
 */
namespace MiniApi;

class MiniProtocolManager extends MiniManager{

	public function __construct() {
		parent::__construct('MiniApi\MiniProtocol');
	}
	
	protected function get_staff_name(MiniRequest $request){
		return $request->protocol();
	}
	
	protected function handle_request(MiniRequest $request, $staff){
		return $staff->call($request);
	}
}
?>