--TEST--
AmazonCloudWatch::list_metrics + NextToken + returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List metrics
	$cw = new AmazonCloudWatch();
	$response = $cw->list_metrics(array(
		'NextToken' => 't', // Invalid
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
