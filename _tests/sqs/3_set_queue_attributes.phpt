--TEST--
AmazonSQS::set_queue_attributes, changing visibility timeout

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Change visibility timeout
	$sqs = new AmazonSQS();
	$response = $sqs->set_queue_attributes('warpshare-unit-test', array(
		'VisibilityTimeout' => 7200
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
