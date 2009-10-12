--TEST--
CloudFront: remove_cname()

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	$cdn = new AmazonCloudFront();

	// Retrieve the cached Distribution ID. See create_distribution() for why we're doing this.
	$distribution_id = file_get_contents('create_distribution.cache');

	// Sample XML content
	$config_xml = $cdn->get_distribution_config($distribution_id)->body;

	// Update the XML content
	$response = $cdn->remove_cname($config_xml, array(
		'unit-test.warpshare.com',
		'unit-test2.warpshare.com'
	));

	// Success?
	var_dump($response);
?>

--EXPECTF--
string(%d) "%s"
