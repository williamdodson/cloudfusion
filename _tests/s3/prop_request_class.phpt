--TEST--
AmazonS3::request_class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->request_class);
?>

--EXPECT--
string(11) "RequestCore"
