--TEST--
CloudFront: generate_config_xml() testing enabled, comments, and single CNAME

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Generate configuration XML
	$cdn = new AmazonCloudFront();
	$response = $cdn->generate_config_xml('warpshare.test.s3.amazonaws.com', 'WarpShareS3', array(
		'Enabled' => true,
		'Comment' => 'This is my sample comment',
		'CNAME' => 'cdn1.warpshare.com'
	));

	// Success?
	var_dump($response);
?>

--EXPECTF--
string(%d) "%s"
