--TEST--
AmazonSDB::delete_attributes multiple

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->delete_attributes('warpshare-unit-test', 'unit-test', array(
		'key2' => 'value1'
	));
	var_dump($response->status);
?>

--EXPECT--
int(200)
