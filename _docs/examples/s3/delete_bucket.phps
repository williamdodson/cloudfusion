<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Delete a bucket as long as it does NOT contain any files.
 */
$deleted = $s3->delete_bucket('warpshare.test.eu');

if ($deleted->isOK())
{
	echo 'Successfully deleted!';
}
echo
{
	echo 'Deletion failed!';
}


/*========================================================*/


/**
 * Force the deletion of a bucket, regardless of whether it contains files or not.
 * We'll set the second parameter to a boolean TRUE to enable forced deletion.
 */
$deleted = $s3->delete_bucket('warpshare.test.eu', true);


?>