<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object, and add a couple of custom headers.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->setMethod(HTTP_PUT);
$request->setBody('This is the body of my request that I want to send to the server.');
$response = $request->sendRequest();

print_r($response);

?>