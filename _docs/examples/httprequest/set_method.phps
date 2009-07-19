<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new RequestCore object, and add a couple of custom headers.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->set_method(HTTP_HEAD);
$response = $request->send_request();

print_r($response);

?>