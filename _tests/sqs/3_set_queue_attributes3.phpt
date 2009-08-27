--TEST--
AmazonSQS::set_queue_attributes, changing visibility timeout (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Change visibility timeout
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->set_queue_attributes('warpshare-unit-test', array(
		'VisibilityTimeout' => 7200
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
