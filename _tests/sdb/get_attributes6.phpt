--TEST--
AmazonSDB::get_attributes specific key string + returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->get_attributes('warpshare-unit-test', 'unit-test', 'key1', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
