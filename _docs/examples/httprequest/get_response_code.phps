<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new RequestCore object
 */
$request = new RequestCore('http://example.com/endpoint');
$request->send_request();

$status = $request->get_response_code();

if ($status == 200)
{
	echo 'Everything is okay!';
}
elseif ($status == 404)
{
	echo 'Page doesn\'t exist!';
}
else
{
	echo 'Some other weird error happened!';
}

?>