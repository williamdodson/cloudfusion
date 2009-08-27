--TEST--
AmazonSDB::delete_attributes single

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->delete_attributes('warpshare-unit-test', 'unit-test', 'key1');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
