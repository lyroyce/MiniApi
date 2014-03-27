<?php
/**
 * Extend this class to enable more protocols
 * @author yinli
 *
 */
namespace MiniApi;

abstract class MiniProtocol {

	private $auth_manager;

	public function __construct() {
		$this->auth_manager = new MiniAuthManager();
		$this->init_auth_registration();
	}
	/**
	 * Send the API request
	 * @param MiniRequest $request a object representing API request
	 * @return MiniResponse a object representing API response
	 */
	public function call(MiniRequest $request){
		$request = $this->auth_manager->handle($request);
		$response = new MiniResponse($request);
		$this->send($request, $response);
		return $response;
	}

	/**
	 * Register handler class for existing or new authentication
	 * @throws Exception if the specified class is not found
	 */
	public function register_auth ($auth, $handler_class) {
		return $this->auth_manager->register_staff($auth, $handler_class);;
	}

	/**
	 * Register all supported authentications during initialization
	 */
	protected abstract function init_auth_registration();
	/**
	 * Send the API request and update response object with actual API response
	 * @param MiniRequest $request a object representing API request
	 * @param MiniResponse $response a object representing API response
	 */
	protected abstract function send(MiniRequest $request, MiniResponse $response);

}
?>