--TEST--
AmazonSQS::receive_message

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a message
	$sqs = new AmazonSQS();
	$response = $sqs->receive_message(SQS_DEFAULT_URL . '/warpshare-unit-test');

	// Store the message receipt in a temp file so that the delete message can grab it later.
	// This is The Wrong Way To Do It™
	file_put_contents('receipt_handle.cache', (string) $response->body->ReceiveMessageResult->Message->ReceiptHandle); // Pass data to delete_message.

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
