--TEST--
AmazonSQSQueue::get_queue_size

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue size
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->get_queue_size();

	// Success?
	var_dump($response);
?>

--EXPECTF--
int(%d)
