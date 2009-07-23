--TEST--
AmazonSDB::delete_attributes key-value pair

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->delete_attributes('warpshare-unit-test', 'unit-test', array(
		'key2',
		'key3'
	));
	var_dump($response->status);
?>

--EXPECT--
int(200)
