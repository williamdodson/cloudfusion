--TEST--
AmazonSDB::create_domain

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->create_domain('warpshare-unit-test');
	var_dump($response->status);
?>

--EXPECT--
int(200)
