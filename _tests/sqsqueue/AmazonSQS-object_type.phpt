--TEST--
AmazonSQSQueue - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQSQueue();
	var_dump(get_class($sqs));
?>

--EXPECT--
string(14) "AmazonSQSQueue"
