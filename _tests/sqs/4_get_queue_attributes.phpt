--TEST--
AmazonSQS::get_queue_attributes

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->get_queue_attributes(SQS_DEFAULT_URL . '/warpshare-unit-test');
	var_dump($response->status);
?>

--EXPECT--
int(200)
