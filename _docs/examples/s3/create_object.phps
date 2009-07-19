<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Store a file inside a bucket.
 */
$file = $s3->create_object('warpshare.test.eu', array(
	'filename' => 'sample.txt',
	'body' => 'This is some sample text that will go into the file.',
	'contentType' => 'text/plain',
	'acl' => S3_ACL_PUBLIC
));


/**
 * Was the file creation successful?
 */
if ($file->isOK())
{
	echo 'Success!';
}
else
{
	echo 'EPIC FAILURE!';
}


?>