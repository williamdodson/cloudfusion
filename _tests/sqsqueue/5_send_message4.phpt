--TEST--
AmazonSQSQueue::send_message with capital letters

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Send a message to the queue
	$sqs = new AmazonSQSQueue('WarpShare-Unit-Test2');
	$response = $sqs->send_message('This is my message.');

	// Success
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
