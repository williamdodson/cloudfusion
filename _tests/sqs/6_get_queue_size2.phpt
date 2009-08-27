--TEST--
AmazonSQS::get_queue_size (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue size
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->get_queue_size('warpshare-unit-test');

	// Success?
	var_dump($response);
?>

--EXPECTF--
int(%d)
