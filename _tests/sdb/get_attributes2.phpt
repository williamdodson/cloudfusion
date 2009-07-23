--TEST--
AmazonSDB::get_attributes specific key

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->get_attributes('warpshare-unit-test', 'unit-test', array(
		'key1'
	));
	var_dump($response->status);
?>

--EXPECT--
int(200)
