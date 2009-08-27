--TEST--
AmazonSDB::list_domains

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->list_domains();

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
