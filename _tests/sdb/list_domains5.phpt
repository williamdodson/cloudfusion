--TEST--
AmazonSDB::list_domains MaxNumberOfDomains + NextToken

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();
	$response = $sdb->list_domains(array(
		'MaxNumberOfDomains' => 1,
		'NextToken' => 't'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
