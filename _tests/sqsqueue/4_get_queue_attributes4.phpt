--TEST--
AmazonSQSQueue::get_queue_attributes, passing a single string as an attribute.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue attributes
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->get_queue_attributes('All');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
