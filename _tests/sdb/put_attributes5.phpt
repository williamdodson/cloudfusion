--TEST--
AmazonSDB::put_attributes selective replace

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->put_attributes('warpshare-unit-test', 'unit-test', array(
		'key1' => 'value1',
		'key2' => array(
			'value1',
			'value2',
			'value3'
		)
	), array('key1'));
	var_dump($response->status);
?>

--EXPECT--
int(200)
