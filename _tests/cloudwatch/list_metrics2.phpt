--TEST--
AmazonCloudWatch::list_metrics + NextToken

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List metrics
	$cw = new AmazonCloudWatch();
	$response = $cw->list_metrics(array(
		'NextToken' => 't' // Invalid
	));

	// Success?
	var_dump($response->body->Errors->Error->Code);
?>

--EXPECT--
bool(false)
