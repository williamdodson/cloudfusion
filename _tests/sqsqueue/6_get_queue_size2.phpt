--TEST--
AmazonSQSQueue::get_queue_size (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue size
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->get_queue_size();

	// Success?
	var_dump($response);
?>

--EXPECTF--
int(%d)
