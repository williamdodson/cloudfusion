--TEST--
AmazonS3::service

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->service);
?>

--EXPECT--
string(8) "AmazonS3"
