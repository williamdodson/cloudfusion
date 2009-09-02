--TEST--
AmazonSQSQueue::delete_message, returning cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a message, returning the cURL handle
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->delete_message(null, true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(10) of type (curl)
