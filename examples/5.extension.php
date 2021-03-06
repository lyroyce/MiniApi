<?php
/**
 * Dependency
 */
require_once __DIR__.'/../vendor/autoload.php';
$api = new MiniApi\MiniApi();

echo "1. Define a new protocol handler for SOAP protocol.\n";
use MiniApi\MiniProtocol;
use MiniApi\MiniRequest;
use MiniApi\MiniResponse;
class MySoapClient extends MiniProtocol{
	protected function init_auth_registration(){}
	protected function send(MiniRequest $request, MiniResponse $response){
		echo "MySoapClient is sending request ...\n";
	}
}

echo "2. register and use the new protocol handler.\n";
$api->register_protocol('SOAP', 'MySoapClient'); // this may cause an expection: Class 'MySoapClient' not found
echo $api->request('http://www.google.com/?wsdl', 'User.New', 'SOAP')
	->call('{"name":"John"}')->debug();

?>