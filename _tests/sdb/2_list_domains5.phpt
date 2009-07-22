--TEST--
AmazonSDB::list_domains MaxNumberOfDomains + NextToken

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->list_domains(array(
		'MaxNumberOfDomains' => 1,
		'NextToken' => 't'
	));
	var_dump($response->status);
?>

--EXPECT--
int(200)
