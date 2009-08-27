--TEST--
AmazonSDB::select

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->select('SELECT * FROM `warpshare-unit-test`');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
