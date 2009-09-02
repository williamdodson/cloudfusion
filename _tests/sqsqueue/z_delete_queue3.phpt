--TEST--
AmazonSQSQueue::delete_queue (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a queue
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->delete_queue();

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
