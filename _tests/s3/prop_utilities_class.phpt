--TEST--
AmazonS3::utilities_class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->utilities_class);
?>

--EXPECT--
string(15) "TarzanUtilities"
