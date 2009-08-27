--TEST--
AmazonSDB::delete_attributes key-value pair returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->delete_attributes('warpshare-unit-test', 'unit-test', array(
		'key2',
		'key3'
	), true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
