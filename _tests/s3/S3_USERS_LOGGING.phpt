--TEST--
AmazonS3::S3_USERS_LOGGING - Return value test

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	echo S3_USERS_LOGGING;
?>

--EXPECT--
http://acs.amazonaws.com/groups/s3/LogDelivery
