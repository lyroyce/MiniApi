<?php
require_once __DIR__.'/../core/MiniApi.php';
$api = new MiniApi();

echo "1. register a new protocol handler for SOAP protocol\n";
$api->register_protocol('SOAP', 'MySoapClient');

echo "2. register a new authentication handler for OAuth\n";
$api->register_auth('OAuth', 'MyOAuthHandler');

?>