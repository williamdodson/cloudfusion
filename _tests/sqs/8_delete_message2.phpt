--TEST--
AmazonSQS::delete_message, returning cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a message, returning the cURL handle
	$sqs = new AmazonSQS();
	$response = $sqs->delete_message(SQS_DEFAULT_URL . '/warpshare-unit-test', null, true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
