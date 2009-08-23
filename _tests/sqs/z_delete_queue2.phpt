--TEST--
AmazonSQS::delete_queue, returning the cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a queue, returning the cURL handle
	$sqs = new AmazonSQS();
	$response = $sqs->delete_queue(SQS_DEFAULT_URL . '/warpshare-unit-test', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
