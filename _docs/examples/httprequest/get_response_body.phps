<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new RequestCore object and fetch the body
 */
$request = new RequestCore('http://example.com/endpoint');
$request->send_request();

// Display the body returned by the request.
echo $request->get_response_body();

?>