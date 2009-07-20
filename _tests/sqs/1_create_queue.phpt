--TEST--
AmazonSQS::create_queue

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->create_queue('warpshare-unit-test');
	var_dump($response->status);
?>

--EXPECT--
int(200)
