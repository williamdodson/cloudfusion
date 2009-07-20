--TEST--
AmazonSQS - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	var_dump(class_exists('AmazonSQS'));
?>

--EXPECT--
bool(true)
