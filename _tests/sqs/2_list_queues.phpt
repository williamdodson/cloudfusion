--TEST--
AmazonSQS::list_queues

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List queues
	$sqs = new AmazonSQS();
	$response = $sqs->list_queues();

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
