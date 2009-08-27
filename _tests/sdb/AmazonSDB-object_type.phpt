--TEST--
AmazonSDB - Object type

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Success?
	var_dump(get_class($sdb));
?>

--EXPECT--
string(9) "AmazonSDB"
