<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new RequestCore object, and add a couple of custom headers.
 */
$request = new RequestCore('http://example.com/endpoint');
$response = $request->send_request();

print_r($response);

?>