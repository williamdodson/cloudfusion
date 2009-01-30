--TEST--
AmazonS3::util

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump(get_class($s3->util));
?>

--EXPECT--
string(15) "TarzanUtilities"
