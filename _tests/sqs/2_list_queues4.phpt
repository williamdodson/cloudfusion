--TEST--
AmazonSQS::list_queues (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List queues
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->list_queues();

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
