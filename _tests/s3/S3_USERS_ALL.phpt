--TEST--
AmazonS3::S3_USERS_ALL - Return value test

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	echo S3_USERS_ALL;
?>

--EXPECT--
http://acs.amazonaws.com/groups/global/AllUsers
