--TEST--
AmazonSQSQueue::send_message curl handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Send a message to the queue, returning the cURL handle
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->send_message('This is my message.', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(10) of type (curl)
