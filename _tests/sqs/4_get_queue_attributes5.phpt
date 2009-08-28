--TEST--
AmazonSQS::get_queue_attributes, passing an array of attributes.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get queue attributes
	$sqs = new AmazonSQS();
	$response = $sqs->get_queue_attributes('warpshare-unit-test', array(
		'ApproximateNumberOfMessages',
		'VisibilityTimeout',
		'CreatedTimestamp',
		'LastModifiedTimestamp',
		'Policy'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
