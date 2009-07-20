--TEST--
AmazonCloudFront - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$cdn = new AmazonCloudFront();
	var_dump(get_class($cdn));
?>

--EXPECT--
string(16) "AmazonCloudFront"
