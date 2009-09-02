--TEST--
AmazonSQSQueue - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQSQueue();
	var_dump(class_exists('AmazonSQSQueue'));
?>

--EXPECT--
bool(true)
