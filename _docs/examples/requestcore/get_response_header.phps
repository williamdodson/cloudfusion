<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object and fetch the headers
 */
$request = new RequestCore('http://example.com/endpoint');
$request->send_request();

// Display ALL of the headers returned by the request.
print_r($request->get_response_header());

// Display ONE of the headers returned by the request.
print_r($request->get_response_header('content-type'));

?>