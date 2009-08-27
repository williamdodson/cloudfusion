--TEST--
AmazonSQS::send_message with capital letters

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Send a message to the queue
	$sqs = new AmazonSQS();
	$response = $sqs->send_message('WarpShare-Unit-Test2', 'This is my message.');

	// Success
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
