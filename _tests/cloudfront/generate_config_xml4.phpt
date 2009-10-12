--TEST--
CloudFront: generate_config_xml() testing enabled, comments, and multiple CNAMEs

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Generate configuration XML
	$cdn = new AmazonCloudFront();
	$response = $cdn->generate_config_xml('warpshare.test.s3.amazonaws.com', 'WarpShareS3', array(
		'Enabled' => true,
		'Comment' => 'This is my sample comment',
		'CNAME' => array(
			'cdn1.warpshare.com',
			'cdn2.warpshare.com',
			'cdn3.warpshare.com'
		)
	));

	// Success?
	var_dump($response);
?>

--EXPECTF--
string(%d) "%s"
