<?php
require_once('tarzan.class.php');

/**
 * Make a request to fetch the data.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->send_request();


/**
 * Pass the returned data from a request into the ResponseCore object.
 */
$response = new ResponseCore(
	$request->get_response_header(),
	$request->get_response_body(),
	$request->get_response_code()
);


/**
 * View the data object.
 */
print_r($response);

?>