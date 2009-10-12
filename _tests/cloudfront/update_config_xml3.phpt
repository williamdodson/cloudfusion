--TEST--
CloudFront: update_config_xml() testing logging

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	$cdn = new AmazonCloudFront();

	// Sample XML content
	$config_xml = $cdn->get_distribution_config('E2L6A3OZHQT5W4')->body;

	// Update the XML content
	$response = $cdn->update_config_xml($config_xml, array(
		'Logging' => array(
			'Bucket' => 'warpshare.logging',
			'Prefix' => 'wslog_'
		)
	));

	// Success?
	var_dump($response);
?>

--EXPECTF--
string(%d) "%s"
