--TEST--
AmazonS3::base_logging_xml

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->base_logging_xml);
?>

--EXPECT--
string(128) "<?xml version="1.0" encoding="utf-8"?><BucketLoggingStatus xmlns="http://doc.s3.amazonaws.com/2006-03-01"></BucketLoggingStatus>"
