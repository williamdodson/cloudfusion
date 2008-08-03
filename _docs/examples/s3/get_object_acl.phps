<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Get the access control settings for the bucket.
 */
$acl = $s3->get_object_acl('warpshare.test.eu', 'sample.txt');


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($acl);
echo '</pre>';


/**
 * Display the owner of the bucket.
 */
echo (string) $acl->body->Owner->DisplayName;


?>