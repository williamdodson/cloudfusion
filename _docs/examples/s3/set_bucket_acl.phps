<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Set the access control settings for the bucket.
 */
$acl = $s3->set_bucket_acl('warpshare.test.eu', S3_ACL_PUBLIC);


/**
 * See the example in s3/generate_access_policy.phps to see how to pass an array of users instead of a canned access policy.
 */


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($acl);
echo '</pre>';


?>