--TEST--
AmazonS3::authenticate (opt fail)

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->authenticate(null));
?>

--EXPECT--
bool(false)
