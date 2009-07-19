--TEST--
AmazonS3::S3_GRANT_WRITE - Return value test

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	echo S3_GRANT_WRITE;
?>

--EXPECT--
WRITE
