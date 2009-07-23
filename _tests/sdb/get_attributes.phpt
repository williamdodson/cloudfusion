--TEST--
AmazonSDB::get_attributes

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->get_attributes('warpshare-unit-test', 'unit-test');
	var_dump($response->status);
?>

--EXPECT--
int(200)
