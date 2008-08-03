<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * A simpler, faster way of checking if a bucket exists as opposed to using head_bucket().
 */
if ($s3->if_object_exists('warpshare.test.eu', 'sample.txt'))
{
	echo 'File exists!';
}
else
{
	echo 'File doesn\'t exist!';
}


?>