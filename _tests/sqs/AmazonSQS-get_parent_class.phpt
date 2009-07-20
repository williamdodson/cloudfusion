--TEST--
AmazonSQS - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	var_dump(get_parent_class('AmazonSQS'));
?>

--EXPECT--
string(11) "CloudFusion"