--TEST--
AmazonSQS::list_queues, with prefix (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List queues with prefix 'a'
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->list_queues('a');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
