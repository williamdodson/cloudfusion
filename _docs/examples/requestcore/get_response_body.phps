<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object and fetch the body
 */
$request = new RequestCore('http://example.com/endpoint');
$request->sendRequest();

// Display the body returned by the request.
echo $request->getResponseBody();

?>