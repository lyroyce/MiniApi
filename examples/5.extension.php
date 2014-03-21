<?php
require_once __DIR__.'/../core/MiniApi.php';
$api = new MiniApi();

echo "1. register a new protocol handler for SOAP protocol.\n";
$api->register_protocol('SOAP', 'MySoapClient'); // this may throw an expection: Class 'MySoapClient' not found
$api->request('http://www.google.com', '/user', 'SOAP')
	->call('{"name":"John"}');

echo "2. register a new authentication handler for OAuth.\n";
$api->register_auth('OAuth', 'MyOAuthHandler'); // this may throw an expection: Class 'MyOAuthHandler' not found
$api->post('http://www.google.com', '/user')
	->auth('OAuth')->prop('auth.someprop', 'example-value')
	->call('{"name":"John"}');

?>