<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Returns a simple array of the names of the buckets for your account.
 */
$list = $s3->get_object_list('warpshare.test.eu');


/**
 * Look at the response to navigate through the headers and body of the response.
 */
echo '<pre>';
print_r($list);
echo '</pre>';


?>