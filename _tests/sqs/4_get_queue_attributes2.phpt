--TEST--
AmazonSQS::get_queue_attributes, returning the cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue attributes, returning the cURL handle
	$sqs = new AmazonSQS();
	$response = $sqs->get_queue_attributes('warpshare-unit-test', null, true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
