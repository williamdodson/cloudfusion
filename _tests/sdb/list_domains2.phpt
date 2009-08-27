--TEST--
AmazonSDB::list_domains MaxNumberOfDomains

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->list_domains(array(
		'MaxNumberOfDomains' => 1
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
