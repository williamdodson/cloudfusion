--TEST--
AmazonSQS::receive_message, only a single message

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a single message
	$sqs = new AmazonSQS();
	$response = $sqs->receive_message(SQS_DEFAULT_URL . '/warpshare-unit-test', array(
		'MaxNumberOfMessages' => 1
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
