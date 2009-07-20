--TEST--
AmazonSQS::list_queues

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->list_queues();
	var_dump($response->status);
?>

--EXPECT--
int(200)
