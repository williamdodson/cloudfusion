--TEST--
AmazonSQS::delete_queue curl handle

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->delete_queue(SQS_DEFAULT_URL . '/warpshare-unit-test', true);
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
