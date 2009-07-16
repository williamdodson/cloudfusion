<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object, and remove a header.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->removeHeader('x-header-one');
$response = $request->sendRequest();

print_r($response);

?>