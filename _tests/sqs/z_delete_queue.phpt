--TEST--
AmazonSQS::delete_queue

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a queue
	$sqs = new AmazonSQS();
	$response = $sqs->delete_queue(SQS_DEFAULT_URL . '/warpshare-unit-test');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
