--TEST--
CloudFront: set_distribution_config() with returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	$cdn = new AmazonCloudFront();

	// Set the updated config XML to the distribution.
	$response = $cdn->set_distribution_config('x', 'x', 'x', array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
