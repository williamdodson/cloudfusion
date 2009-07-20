--TEST--
AmazonSQS::delete_message curl handle

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->delete_message(SQS_DEFAULT_URL . '/warpshare-unit-test', null, true);
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
