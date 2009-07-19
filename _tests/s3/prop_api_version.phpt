--TEST--
AmazonS3::api_version

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->api_version);
?>

--EXPECT--
string(10) "2006-03-01"
