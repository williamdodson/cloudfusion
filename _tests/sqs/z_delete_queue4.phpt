--TEST--
AmazonSQS::delete_queue with capital letters

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a queue
	$sqs = new AmazonSQS();
	$response = $sqs->delete_queue('WarpShare-Unit-Test2');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
