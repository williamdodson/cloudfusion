--TEST--
AmazonSDB::delete_domain

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->delete_domain('warpshare-unit-test');
	var_dump($response->status);
?>

--EXPECT--
int(200)
