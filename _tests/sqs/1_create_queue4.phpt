--TEST--
AmazonSQS::create_queue with capital letters

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Create a queue
	$sqs = new AmazonSQS();
	$response = $sqs->create_queue('WarpShare-Unit-Test2');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
