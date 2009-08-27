--TEST--
AmazonSDB::create_domain curl handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->create_domain('warpshare-unit-test', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
