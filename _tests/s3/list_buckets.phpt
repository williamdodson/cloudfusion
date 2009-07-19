--TEST--
AmazonS3::list_buckets

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	$operation = $s3->list_buckets();
	echo $operation->status;
?>

--EXPECT--
200
