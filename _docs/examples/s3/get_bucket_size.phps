<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Displays the number of items inside the bucket. This will (obviously) be an integer value.
 */
echo $s3->get_bucket_size('warpshare.test.eu');


?>