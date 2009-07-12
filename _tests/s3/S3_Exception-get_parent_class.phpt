--TEST--
AmazonS3::S3_Exception - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump(get_parent_class('S3_Exception'));
?>

--EXPECT--
string(9) "Exception"
