--TEST--
AmazonSDB::batch_put_attributes with replace all

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Test data
	$response = $sdb->batch_put_attributes('warpshare-unit-test', array(
		'item1' => array(
			'key1' => 'value1',
			'key2' => array(
				'value1',
				'value2',
				'value3',
			),
			'key3' => array('value1'),
		),
		'item2' => array(
			'key1' => 'value1',
			'key2' => array(
				'value1',
				'value2',
				'value3',
			),
			'key3' => array('value1'),
		),
		'item3' => array(
			'key1' => 'value1',
			'key2' => array(
				'value1',
				'value2',
				'value3',
			),
			'key3' => array('value1'),
		),
	), true);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
