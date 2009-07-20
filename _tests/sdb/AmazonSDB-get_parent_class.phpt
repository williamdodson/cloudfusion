--TEST--
AmazonSDB - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	var_dump(get_parent_class('AmazonSDB'));
?>

--EXPECT--
string(11) "CloudFusion"