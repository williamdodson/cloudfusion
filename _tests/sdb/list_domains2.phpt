--TEST--
AmazonSDB::list_domains MaxNumberOfDomains

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->list_domains(array(
		'MaxNumberOfDomains' => 1
	));
	var_dump($response->status);
?>

--EXPECT--
int(200)
