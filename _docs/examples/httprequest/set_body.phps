<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new RequestCore object, and add a couple of custom headers.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->set_method(HTTP_PUT);
$request->set_body('This is the body of my request that I want to send to the server.');
$response = $request->send_request();

print_r($response);

?>