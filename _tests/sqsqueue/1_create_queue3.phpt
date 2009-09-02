--TEST--
AmazonSQSQueue::create_queue (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Create a queue
	$sqs = new AmazonSQSQueue();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->create_queue('warpshare-unit-test');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
