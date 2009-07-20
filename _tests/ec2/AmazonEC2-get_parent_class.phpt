--TEST--
AmazonEC2 - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$ec2 = new AmazonEC2();
	var_dump(get_parent_class('AmazonEC2'));
?>

--EXPECT--
string(11) "CloudFusion"