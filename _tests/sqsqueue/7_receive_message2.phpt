--TEST--
AmazonSQSQueue::receive_message, returning cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a message, returning the cURL handle
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->receive_message(array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(10) of type (curl)
