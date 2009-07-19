--TEST--
AmazonS3::S3_LOCATION_US - Return value test

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	echo S3_LOCATION_US;
?>

--EXPECT--
us
