<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Store a remote file in S3.
 */
$file_url = $s3->store_remote_file('http://yahoo.com', 'warpshare.test.eu', 'yahoo_home.html', array(
	'acl' => S3_ACL_PUBLIC
));


/**
 * Display the new S3 URL for the stored file. (http://warpshare.test.eu.s3.amazonaws.com/yahoo_home.html)
 */
echo $file_url;


?>