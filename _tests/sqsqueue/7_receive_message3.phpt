--TEST--
AmazonSQSQueue::receive_message, change visibility timeout

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a message, and allow more time to process
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->receive_message(array(
		'VisibilityTimeout' => 7200
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
