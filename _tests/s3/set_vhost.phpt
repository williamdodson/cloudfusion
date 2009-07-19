--TEST--
AmazonS3::set_vhost

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	$s3->set_vhost('s3.amazonaws.com');
	$s3->list_buckets();
	var_dump($s3->vhost);
?>

--EXPECT--
string(16) "s3.amazonaws.com"