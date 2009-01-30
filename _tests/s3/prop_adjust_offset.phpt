--TEST--
AmazonS3::adjust_offset

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../tarzan.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->adjust_offset);
?>

--EXPECT--
int(0)
