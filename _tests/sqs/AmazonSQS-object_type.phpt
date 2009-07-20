--TEST--
AmazonSQS - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	var_dump(get_class($sqs));
?>

--EXPECT--
string(9) "AmazonSQS"
