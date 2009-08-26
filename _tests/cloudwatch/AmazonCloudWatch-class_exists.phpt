--TEST--
AmazonCloudWatch - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$cw = new AmazonCloudWatch();
	var_dump(class_exists('AmazonCloudWatch'));
?>

--EXPECT--
bool(true)
