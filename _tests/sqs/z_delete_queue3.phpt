--TEST--
AmazonSQS::delete_queue (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a queue
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->delete_queue('warpshare-unit-test');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
