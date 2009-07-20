--TEST--
AmazonAAWS - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonAAWS();
	var_dump(get_class($s3));
?>

--EXPECT--
string(10) "AmazonAAWS"
