<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Rename a file.
 */
$rename = $s3->rename_object('warpshare.test.eu', 'sample.txt', 'sample2.txt');


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($rename);
echo '</pre>';


?>