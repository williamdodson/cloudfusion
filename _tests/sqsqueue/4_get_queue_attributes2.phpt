--TEST--
AmazonSQSQueue::get_queue_attributes, returning the cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue attributes, returning the cURL handle
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->get_queue_attributes(null, true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(10) of type (curl)
