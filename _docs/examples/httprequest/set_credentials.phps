<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new RequestCore object, and set authentication credentials to use for login.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->set_credentials('username', 'password');
$response = $request->send_request();

print_r($response);

?>