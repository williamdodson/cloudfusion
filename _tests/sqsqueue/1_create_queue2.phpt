--TEST--
AmazonSQSQueue::create_queue, returning the cURL handle.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Create a queue
	$sqs = new AmazonSQSQueue();
	$response = $sqs->create_queue('warpshare-unit-test', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(10) of type (curl)
