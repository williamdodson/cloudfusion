--TEST--
AmazonSQS::receive_message, only a single message (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a single message
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->receive_message('warpshare-unit-test', array(
		'MaxNumberOfMessages' => 1
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
