--TEST--
AmazonSQS::delete_message

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->delete_message(SQS_DEFAULT_URL . '/warpshare-unit-test', file_get_contents('receipt_handle.cache'));
	var_dump($response->status);
?>

--EXPECT--
int(200)

--CLEAN--
<?php
	unlink('receipt_handle.cache');
?>
