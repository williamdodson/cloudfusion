--TEST--
AmazonSQS::send_message

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->send_message(SQS_DEFAULT_URL . '/warpshare-unit-test', 'This is my message.');
	var_dump($response->status);
?>

--EXPECT--
int(200)
