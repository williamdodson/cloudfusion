--TEST--
AmazonSQS::receive_message (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a message
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->receive_message('warpshare-unit-test');

	// Store the message receipt in a temp file so that the delete message can grab it later.
	// This is The Wrong Way To Do It™
	file_put_contents('receipt_handle_eu.cache', (string) $response->body->ReceiveMessageResult->Message->ReceiptHandle); // Pass data to delete_message.

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
