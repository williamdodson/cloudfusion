--TEST--
AmazonSQSQueue::delete_queue

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a queue
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->delete_queue();

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
