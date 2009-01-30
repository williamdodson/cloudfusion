--TEST--
AmazonS3::enable_ssl

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->enable_ssl);
?>

--EXPECT--
bool(true)
