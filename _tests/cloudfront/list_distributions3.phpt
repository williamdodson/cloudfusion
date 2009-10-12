--TEST--
CloudFront: list_distributions() with MaxResults

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Update the XML content
	$cdn = new AmazonCloudFront();
	$response = $cdn->list_distributions(array(
		'MaxItems' => 1,
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
