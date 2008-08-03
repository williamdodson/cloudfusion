<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Delete an object.
 */
$delete = $s3->delete_object('warpshare.test.eu', 'sample.txt');


/**
 * Check the status of the bucket.
 */
if ($delete->isOK())
{
	echo 'File deleted!';
}
else
{
	echo 'File deletion failed!';
}


?>