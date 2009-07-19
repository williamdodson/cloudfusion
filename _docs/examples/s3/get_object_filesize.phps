<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Returns the file size of the bucket, in bytes (e.g. 849666).
 */
echo $s3->get_object_filesize('warpshare.test.eu', 'sample.txt');


/**
 * Returns the file size of the bucket, in the largest "friendly" units that make sense (e.g. 829.75 kB).
 */
echo $s3->get_object_filesize('warpshare.test.eu', 'sample.txt', true);


?>