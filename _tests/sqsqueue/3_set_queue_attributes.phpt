--TEST--
AmazonSQSQueue::set_queue_attributes, changing visibility timeout

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Change visibility timeout
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->set_queue_attributes(array(
		'VisibilityTimeout' => 7200
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
