--TEST--
CloudFront: list_distributions()

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Update the XML content
	$cdn = new AmazonCloudFront();
	$response = $cdn->list_distributions();

	// Success?
	var_dump($response->isOK());
?>

--EXPECTF--
bool(true)
