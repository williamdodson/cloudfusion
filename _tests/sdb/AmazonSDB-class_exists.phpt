--TEST--
AmazonSDB - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	var_dump(class_exists('AmazonSDB'));
?>

--EXPECT--
bool(true)
