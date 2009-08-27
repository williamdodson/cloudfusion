--TEST--
AmazonSQS::send_message (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Send a message to the queue
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->send_message('warpshare-unit-test', 'This is my message.');

	// Success
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
