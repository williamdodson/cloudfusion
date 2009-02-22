<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object, and add a couple of custom headers.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->add_header('x-header-one', 'my custom value');
$request->add_header('x-header-two', 'another custom value');
$response = $request->send_request();

print_r($response);

?>