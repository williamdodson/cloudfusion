<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new TarzanHTTPRequest object.
 */
$request = new TarzanHTTPRequest('http://example.com/endpoint');


/**
 * Instantiate a new TarzanHTTPRequest object using proxy settings. Make sure you use the 'proxy://' scheme.
 */
$request = new TarzanHTTPRequest('http://example.com/endpoint', 'proxy://user:pass@hostname:port');


/**
 * Instantiate a new TarzanHTTPRequest object, but use a custom class for utilities.
 */
$request = new TarzanHTTPRequest('http://example.com/endpoint', null, array(
	'utilities' => 'CustomUtilities'
));

class CustomUtilities extends TarzanUtilities
{
	public function new_method()
	{
		// Do stuff...
	}
}

?>