--TEST--
AmazonSQSQueue::list_queues, with prefix, returning cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List queues, with prefix 'a', returning the cURL handle
	$sqs = new AmazonSQSQueue();
	$response = $sqs->list_queues('a', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(10) of type (curl)
