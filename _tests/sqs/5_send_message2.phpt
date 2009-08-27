--TEST--
AmazonSQS::send_message curl handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Send a message to the queue, returning the cURL handle
	$sqs = new AmazonSQS();
	$response = $sqs->send_message('warpshare-unit-test', 'This is my message.', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
