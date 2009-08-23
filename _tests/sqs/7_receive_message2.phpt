--TEST--
AmazonSQS::receive_message, returning cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a message, returning the cURL handle
	$sqs = new AmazonSQS();
	$response = $sqs->receive_message(SQS_DEFAULT_URL . '/warpshare-unit-test', array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
