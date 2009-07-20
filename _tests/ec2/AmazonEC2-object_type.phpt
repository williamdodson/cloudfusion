--TEST--
AmazonEC2 - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$ec2 = new AmazonEC2();
	var_dump(get_class($ec2));
?>

--EXPECT--
string(9) "AmazonEC2"
