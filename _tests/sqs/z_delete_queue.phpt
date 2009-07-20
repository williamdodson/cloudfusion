--TEST--
AmazonSQS::delete_queue

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->delete_queue(SQS_DEFAULT_URL . '/warpshare-unit-test');
	var_dump($response->status);
?>

--EXPECT--
int(200)
