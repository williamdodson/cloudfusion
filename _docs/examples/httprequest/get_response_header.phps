<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object and fetch the headers
 */
$request = new RequestCore('http://example.com/endpoint');
$request->sendRequest();

// Display ALL of the headers returned by the request.
print_r($request->getResponseHeader());

// Display ONE of the headers returned by the request.
print_r($request->getResponseHeader('content-type'));

?>