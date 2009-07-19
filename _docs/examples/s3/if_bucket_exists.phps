<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * A simpler, faster way of checking if a bucket exists as opposed to using head_bucket().
 */
if ($s3->if_bucket_exists('warpshare.test.eu'))
{
	echo 'Bucket exists!';
}
else
{
	echo 'Bucket doesn\'t exist!';
}


?>