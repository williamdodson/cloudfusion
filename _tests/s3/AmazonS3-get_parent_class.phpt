--TEST--
AmazonS3 - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump(get_parent_class('AmazonS3'));
?>

--EXPECT--
string(10) "CloudCore"
