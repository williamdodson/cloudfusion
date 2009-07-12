--TEST--
AmazonS3::vhost

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->vhost);
?>

--EXPECT--
NULL
