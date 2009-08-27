--TEST--
AmazonSQS::get_queue_attributes (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue attributes
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->get_queue_attributes('warpshare-unit-test');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
