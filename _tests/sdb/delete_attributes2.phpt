--TEST--
AmazonSDB::delete_attributes single

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->delete_attributes('warpshare-unit-test', 'unit-test', 'key1');
	var_dump($response->status);
?>

--EXPECT--
int(200)
