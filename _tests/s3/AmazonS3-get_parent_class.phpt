--TEST--
AmazonS3 - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump(get_parent_class('AmazonS3'));
?>

--EXPECT--
string(9) "CloudCore"