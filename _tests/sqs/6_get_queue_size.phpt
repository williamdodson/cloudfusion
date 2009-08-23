--TEST--
AmazonSQS::get_queue_size

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue size
	$sqs = new AmazonSQS();
	$response = $sqs->get_queue_size(SQS_DEFAULT_URL . '/warpshare-unit-test');

	// Success?
	var_dump($response);
?>

--EXPECT--
int(0)
