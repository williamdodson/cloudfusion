--TEST--
AmazonS3 - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump(class_exists('AmazonS3'));
?>

--EXPECT--
bool(true)
