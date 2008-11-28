<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonCloudFront object using the settings from the config.inc.php file.
 */
$cf = new AmazonCloudFront();


/**
 * Create a new CloudFront distribution from an existing S3 bucket.
 */
$caller_reference = sha1(time() . $cf->key);

$create = $cf->create_distribution('warpshare_test', $caller_reference, array(
	'Comment' => 'This is my special comment.',
	'CNAME' => 'cdn.warpshare.com'
));

// Response for the creation.
print_r($create);

?>