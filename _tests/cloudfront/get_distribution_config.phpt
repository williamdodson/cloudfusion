--TEST--
CloudFront: get_distribution_config()

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Retrieve the cached Distribution ID. See create_distribution() for why we're doing this.
	$distribution_id = file_get_contents('create_distribution.cache');

	// Get distribution info
	$cdn = new AmazonCloudFront();
	$response = $cdn->get_distribution_config($distribution_id);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
