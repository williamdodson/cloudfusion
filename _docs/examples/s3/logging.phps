<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Set the correct permissions for your bucket that will store the logs.
 */
$s3->set_bucket_acl('warpshare.logging', array(
	array(
		'id' => S3_USERS_LOGGING, 
		'permission'=> S3_GRANT_WRITE
	),
	array(
		'id' => S3_USERS_LOGGING, 
		'permission'=> S3_GRANT_READ_ACP
	),
	array(
		'id' => 'amazon-test@warpshare.com', 
		'permission'=> S3_GRANT_FULL_CONTROL
	),
));


/**
 * Enable logging for one bucket, storing the logs in another.
 * Ensure another Amazon user has special permissions.
 */
$s3->enable_logging('s3.warpshare.com', 'warpshare.logging', 'logs_', array(
	'amazon-test@warpshare.com' => S3_GRANT_FULL_CONTROL
));


/**
 * Get the logs
 */
$logs = $s3->get_logs('warpshare.logging');
print_r($logs);


/**
 * Disable logging
 */
$s3->disable_logging('s3.warpshare.com');

?>