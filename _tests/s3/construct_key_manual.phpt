--TEST--
AmazonS3::__construct (key manual)

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3('key', 'secret');
	var_dump($s3->key);
	var_dump($s3->secret_key);
?>

--EXPECT--
string(3) "key"
string(6) "secret"