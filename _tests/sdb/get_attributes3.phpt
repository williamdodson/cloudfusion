--TEST--
AmazonSDB::get_attributes returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->get_attributes('warpshare-unit-test', 'unit-test', null, true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
