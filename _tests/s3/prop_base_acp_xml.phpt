--TEST--
AmazonS3::base_acp_xml

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->base_acp_xml);
?>

--EXPECT--
string(129) "<?xml version="1.0" encoding="utf-8"?><AccessControlPolicy xmlns="http://s3.amazonaws.com/doc/2006-03-01/"></AccessControlPolicy>"
