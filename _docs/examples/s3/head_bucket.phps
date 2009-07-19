<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Get the HTTP headers for the bucket. Mostly useful for checking if a bucket exists (and is owned by you).
 */
$head = $s3->head_bucket('warpshare.test.eu');


/**
 * Check the status of the bucket.
 */
if ($head->isOK())
{
	echo 'Bucket exists!';
}
else
{
	echo 'Bucket doesn\'t exist!';
}


?>