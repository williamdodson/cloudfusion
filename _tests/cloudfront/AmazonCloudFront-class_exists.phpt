--TEST--
AmazonCloudFront - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump(class_exists('AmazonCloudFront'));
?>

--EXPECT--
bool(true)
