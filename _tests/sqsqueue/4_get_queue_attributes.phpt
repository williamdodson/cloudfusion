--TEST--
AmazonSQSQueue::get_queue_attributes

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue attributes
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->get_queue_attributes();

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
