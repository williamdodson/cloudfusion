--TEST--
AmazonSQS::receive_message, multiple attributes

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Receive a single message
	$sqs = new AmazonSQS();
	$response = $sqs->receive_message('warpshare-unit-test', array(
		'AttributeName' => array(
			'SenderId',
			'SentTimestamp'
		)
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
