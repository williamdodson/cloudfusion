--TEST--
AmazonS3::S3_Exception - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump(class_exists('S3_Exception'));
?>

--EXPECT--
bool(true)
