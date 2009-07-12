--TEST--
AmazonS3 - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump(get_class($s3));
?>

--EXPECT--
string(8) "AmazonS3"
