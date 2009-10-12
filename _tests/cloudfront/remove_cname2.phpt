--TEST--
CloudFront: remove_cname() using full ResponseCore object

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	$cdn = new AmazonCloudFront();

	// Retrieve the cached Distribution ID. See create_distribution() for why we're doing this.
	$distribution_id = file_get_contents('create_distribution.cache');

	// Sample XML content
	$config_xml = $cdn->get_distribution_config($distribution_id);

	// Update the XML content
	$response = $cdn->remove_cname($config_xml, 'unit-test.warpshare.com');

	// Success?
	var_dump($response);
?>

--EXPECTF--
string(%d) "%s"
