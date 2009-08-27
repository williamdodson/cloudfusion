--TEST--
AmazonSDB::delete_attributes

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->delete_attributes('warpshare-unit-test', 'unit-test');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
