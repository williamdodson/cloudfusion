--TEST--
AmazonCloudWatch - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$cw = new AmazonCloudWatch();
	var_dump(get_parent_class('AmazonCloudWatch'));
?>

--EXPECT--
string(11) "CloudFusion"