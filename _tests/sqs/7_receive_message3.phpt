--TEST--
AmazonSQS::receive_message, change visibility timeout

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a message, and allow more time to process
	$sqs = new AmazonSQS();
	$response = $sqs->receive_message(SQS_DEFAULT_URL . '/warpshare-unit-test', array(
		'VisibilityTimeout' => 7200
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
