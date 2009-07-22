--TEST--
AmazonSDB::list_domains MaxNumberOfDomains + NextToken + returnCurlHandle

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->list_domains(array(
		'MaxNumberOfDomains' => 1,
		'NextToken' => 't',
		'returnCurlHandle' => true
	));
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
