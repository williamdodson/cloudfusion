<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object, and add a couple of custom headers.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->setMethod(HTTP_HEAD);
$response = $request->sendRequest();

print_r($response);

?>