--TEST--
AmazonSQS::receive_message

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->receive_message(SQS_DEFAULT_URL . '/warpshare-unit-test');
	file_put_contents('receipt_handle.cache', (string) $response->body->ReceiveMessageResult->Message->ReceiptHandle); // Pass data to delete_message.
	var_dump($response->status);
?>

--EXPECT--
int(200)
