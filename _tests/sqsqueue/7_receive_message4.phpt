--TEST--
AmazonSQSQueue::receive_message, only a single message

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a single message
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->receive_message(array(
		'MaxNumberOfMessages' => 1
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
