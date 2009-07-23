--TEST--
AmazonSDB::select

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->select('SELECT * FROM `warpshare-unit-test`');
	var_dump($response->status);
?>

--EXPECT--
int(200)
