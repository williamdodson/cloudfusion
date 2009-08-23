--TEST--
AmazonSQS::create_queue, returning the cURL handle.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Create a queue
	$sqs = new AmazonSQS();
	$response = $sqs->create_queue('warpshare-unit-test', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
