--TEST--
AmazonSQSQueue::receive_message, single attribute

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a single message
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->receive_message(array(
		'AttributeName' => 'SenderId'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
