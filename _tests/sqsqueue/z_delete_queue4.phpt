--TEST--
AmazonSQSQueue::delete_queue with capital letters

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a queue
	$sqs = new AmazonSQSQueue('WarpShare-Unit-Test2');
	$response = $sqs->delete_queue();

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
