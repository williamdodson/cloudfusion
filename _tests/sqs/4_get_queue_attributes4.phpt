--TEST--
AmazonSQS::get_queue_attributes, passing a single string as an attribute.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue attributes
	$sqs = new AmazonSQS();
	$response = $sqs->get_queue_attributes('warpshare-unit-test', 'All');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
