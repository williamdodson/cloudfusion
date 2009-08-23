--TEST--
AmazonSQS::get_queue_attributes

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue attributes
	$sqs = new AmazonSQS();
	$response = $sqs->get_queue_attributes(SQS_DEFAULT_URL . '/warpshare-unit-test');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
