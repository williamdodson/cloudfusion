<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object, and remove a header.
 */
$request = new RequestCore('http://example.com/endpoint');
$request->remove_header('x-header-one');
$response = $request->send_request();

print_r($response);

?>