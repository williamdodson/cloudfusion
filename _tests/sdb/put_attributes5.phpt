--TEST--
AmazonSDB::put_attributes selective replace

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->put_attributes('warpshare-unit-test', 'unit-test', array(
		'key1' => 'value1',
		'key2' => array(
			'value1',
			'value2',
			'value3'
		)
	), array('key1'));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
