<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Get the HTTP headers for the bucket. Mostly useful for checking if a bucket exists (and is owned by you).
 */
$head = $s3->head_object('warpshare.test.eu', 'sample.txt');


/**
 * Check the status of the bucket.
 */
if ($head->isOK())
{
	echo 'File exists!';
}
else
{
	echo 'File doesn\'t exist!';
}


?>