<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Copy a file to a new bucket with a new name.
 */
$contentType = $s3->change_content_type('warpshare.test.eu', 'sample.txt', 'application/x-www-form-urlencoded');


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($contentType);
echo '</pre>';

?>