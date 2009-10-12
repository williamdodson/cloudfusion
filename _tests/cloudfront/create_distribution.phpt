--TEST--
CloudFront: create_distribution()

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Create a new CloudFront distribution from an S3 bucket.
	$cdn = new AmazonCloudFront();
	$response = $cdn->create_distribution('warpshare.test', 'TarzanDemo', array(
		'Enabled' => true,
		'Comment' => 'This is my sample comment',
		'CNAME' => 'unit-test.warpshare.com',
		'Logging' => array(
			'Bucket' => 'warpshare.logging',
			'Prefix' => 'wslog_'
		)
	));

	// Store the Distribution ID so that we can re-use it later. This is useful for unit testing.
	// This is The Wrong Way To Do It™
	file_put_contents('create_distribution.cache', (string) $response->body->Id);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
