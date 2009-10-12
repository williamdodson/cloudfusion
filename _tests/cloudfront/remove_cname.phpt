--TEST--
CloudFront: remove_cname()

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	$cdn = new AmazonCloudFront();

	// Sample XML content
	$config_xml = $cdn->get_distribution_config('E2L6A3OZHQT5W4')->body;

	// Update the XML content
	$response = $cdn->remove_cname($config_xml, 'unit-test.warpshare.com');

	// Success?
	var_dump($response);
?>

--EXPECTF--
string(%d) "%s"
