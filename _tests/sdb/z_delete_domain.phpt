--TEST--
AmazonSDB::delete_domain

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->delete_domain('warpshare-unit-test');

	// Success?
	var_dump($response->status);
?>

--EXPECT--
int(200)
