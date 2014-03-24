<?php
require_once __DIR__.'/../core/MiniApi.php';
$api = new MiniApi();

echo "1. register a new protocol handler for SOAP protocol.\n";
$api->register_protocol('SOAP', 'MySoapClient'); // this may throw an expection: Class 'MySoapClient' not found
echo $api->request('http://www.google.com/?wsdl', 'User.New', 'SOAP')
	->call('{"name":"John"}')->debug();

?>