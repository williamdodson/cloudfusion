<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new RequestCore object
 */
$request = new RequestCore('http://example.com/endpoint');
$request->sendRequest();

$status = $request->getResponseCode();

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