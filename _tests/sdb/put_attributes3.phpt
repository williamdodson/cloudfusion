--TEST--
AmazonSDB::put_attributes returnCurlHandle

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
	), false, true);
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
