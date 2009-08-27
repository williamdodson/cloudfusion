--TEST--
AmazonSQS::send_message

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Send a message to the queue
	$sqs = new AmazonSQS();
	$response = $sqs->send_message('warpshare-unit-test', 'This is my message.');

	// Success
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
