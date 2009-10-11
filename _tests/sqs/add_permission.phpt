--TEST--
AmazonSQS::add_permission

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Add permissions to a queue
	$sqs = new AmazonSQS();
	$response = $sqs->add_permission('warpshare-unit-test', 'WarpShareTesting', array(
		'133904017518' => array(
			'GetQueueAttributes',
			'ChangeVisbilityTimeout'
		)
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
