--TEST--
AmazonSQS::get_queue_size

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->get_queue_size(SQS_DEFAULT_URL . '/warpshare-unit-test');
	var_dump($response);
?>

--EXPECT--
int(0)
