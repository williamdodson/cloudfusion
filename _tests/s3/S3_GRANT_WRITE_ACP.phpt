--TEST--
AmazonS3::S3_GRANT_WRITE_ACP - Return value test

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	echo S3_GRANT_WRITE_ACP;
?>

--EXPECT--
WRITE_ACP
