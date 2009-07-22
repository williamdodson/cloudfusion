--TEST--
AmazonSDB::domain_metadata

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->domain_metadata('warpshare-unit-test');
	var_dump($response->status);
?>

--EXPECT--
int(200)
