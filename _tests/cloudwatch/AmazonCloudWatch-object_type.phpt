--TEST--
AmazonCloudWatch - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$cw = new AmazonCloudWatch();
	var_dump(get_class($cw));
?>

--EXPECT--
string(16) "AmazonCloudWatch"
