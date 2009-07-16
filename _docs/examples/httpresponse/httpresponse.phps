<?php
require_once('tarzan.class.php');

/**
 * Make a request to fetch the data.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->sendRequest();


/**
 * Pass the returned data from a request into the ResponseCore object.
 */
$response = new ResponseCore(
	$request->getResponseHeader(),
	$request->getResponseBody(),
	$request->getResponseCode()
);


/**
 * View the data object.
 */
print_r($response);

?>