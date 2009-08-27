--TEST--
AmazonSDB::get_attributes specific key

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->get_attributes('warpshare-unit-test', 'unit-test', array(
		'key1'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
