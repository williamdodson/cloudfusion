--TEST--
AmazonS3::S3_USERS_AUTH - Return value test

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	echo S3_USERS_AUTH;
?>

--EXPECT--
http://acs.amazonaws.com/groups/global/AuthenticatedUsers
