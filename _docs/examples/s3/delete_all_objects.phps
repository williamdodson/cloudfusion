<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Delete all objects in a bucket.
 */
$delete = $s3->delete_all_objects('warpshare.test.eu');


?>