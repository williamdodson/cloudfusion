<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object, and set authentication credentials to use for login.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->setCredentials('username', 'password');
$response = $request->sendRequest();

print_r($response);

?>