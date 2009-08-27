--TEST--
AmazonSDB - Exists

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Success?
	var_dump(class_exists('AmazonSDB'));
?>

--EXPECT--
bool(true)
