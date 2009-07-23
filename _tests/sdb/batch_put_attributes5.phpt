--TEST--
AmazonSDB::batch_put_attributes with replace specific + returnCurlHandle

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
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
	), true);
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
