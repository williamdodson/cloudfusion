<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Display the URL for accessing the .torrent for this file in this bucket.
 */
echo $s3->get_torrent_url('warpshare.test.eu', 'sample.txt');


?>