--TEST--
AmazonSDB::batch_put_attributes with replace specific

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
	), array(
		'item1' => array(
			'key2'
		),
		'item3' => array(
			'key3'
		),
	));
	$url = $response->header['_info']['url'];

	// Are these stored in the URL properly?
	var_dump((stristr($url, 'Item.0.Attribute.0.Replace') !== false) ? true : false);
	var_dump((stristr($url, 'Item.0.Attribute.1.Replace') !== false) ? true : false);
	var_dump((stristr($url, 'Item.0.Attribute.2.Replace') !== false) ? true : false);
	var_dump((stristr($url, 'Item.0.Attribute.3.Replace') !== false) ? true : false);
	var_dump((stristr($url, 'Item.2.Attribute.5.Replace') !== false) ? true : false);
?>

--EXPECT--
bool(false)
bool(true)
bool(true)
bool(true)
bool(true)
