--TEST--
AmazonSQSQueue::delete_queue, returning the cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a queue, returning the cURL handle
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->delete_queue(true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(10) of type (curl)
