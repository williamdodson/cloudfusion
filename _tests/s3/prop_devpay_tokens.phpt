--TEST--
AmazonS3::devpay_tokens

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->devpay_tokens);
?>

--EXPECT--
NULL
