--TEST--
AmazonAAWS - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonAAWS();
	var_dump(class_exists('AmazonAAWS'));
?>

--EXPECT--
bool(true)
