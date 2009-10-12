--TEST--
CloudFront: generate_config_xml() testing logging with FQDN

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Generate configuration XML
	$cdn = new AmazonCloudFront();
	$response = $cdn->generate_config_xml('warpshare.test.s3.amazonaws.com', 'WarpShareS3', array(
		'Logging' => array(
			'Bucket' => 'warpshare.logging.s3.amazonaws.com',
			'Prefix' => 'wslog_'
		)
	));

	// Success?
	var_dump($response);
?>

--EXPECTF--
string(%d) "%s"
