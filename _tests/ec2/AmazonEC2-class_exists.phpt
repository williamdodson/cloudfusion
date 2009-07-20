--TEST--
AmazonEC2 - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$ec2 = new AmazonEC2();
	var_dump(class_exists('AmazonEC2'));
?>

--EXPECT--
bool(true)
