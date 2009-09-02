--TEST--
AmazonSQSQueue - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQSQueue();
	var_dump(get_parent_class('AmazonSQSQueue'));
?>

--EXPECT--
string(9) "AmazonSQS"
