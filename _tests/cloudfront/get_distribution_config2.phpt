--TEST--
CloudFront: get_distribution_config() with returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get distribution info
	$cdn = new AmazonCloudFront();
	$response = $cdn->get_distribution_config('E2L6A3OZHQT5W4', array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
