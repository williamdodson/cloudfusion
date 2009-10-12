--TEST--
CloudFront: create_distribution() with returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Create a new CloudFront distribution from an S3 bucket.
	$cdn = new AmazonCloudFront();
	$response = $cdn->create_distribution('warpshare.test', 'TarzanDemo', array(
		'Enabled' => true,
		'Comment' => 'This is my sample comment',
		'CNAME' => 'cf.warpshare.com',
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
