--TEST--
AmazonS3::S3_PCRE_ALL - Return value test

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	echo S3_PCRE_ALL;
?>

--EXPECT--
/.*/i
