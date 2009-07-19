--TEST--
AmazonS3::util

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump(get_class($s3->util));
?>

--EXPECT--
string(11) "CFUtilities"