--TEST--
AmazonSDB::domain_metadata returnCurlHandle

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->domain_metadata('warpshare-unit-test', true);
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
