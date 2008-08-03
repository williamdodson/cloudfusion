<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Retrieve a file from S3.
 */
$file = $s3->get_object('warpshare.test.eu', 'sample.txt');


/**
 * Display the file, setting the correct content-type.
 */
header('Content-type:' . $file->headers['content-type']);
echo $file->body;


?>