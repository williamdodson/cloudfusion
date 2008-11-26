<?php
require_once('tarzan.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Converts a number of seconds into HH:MM:SS format.
 */
echo $s3->util->time_hms(12345) . ' has elapsed.';

?>