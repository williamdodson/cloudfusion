<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonSDB object using the settings from the config.inc.php file.
 */
$sdb = new AmazonSDB();


/**
 * Return a list of domains for your SimpleDB account.
 */
$domains = $sdb->list_domains();


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($domains);
echo '</pre>';


?>