--TEST--
AmazonSDB::cache_response MultiCurl CacheAPC

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Prepare for parallel requests
	$handles = array();
	$handles[] = $sdb->list_domains(array(
		'returnCurlHandle' => true
	));
	$handles[] = $sdb->list_domains(array(
		'returnCurlHandle' => true
	));

	// Instantiate
	$http = new RequestCore(null);

	// First time pulls live data
	$response = $sdb->cache_response(array($http, 'send_multi_request'), 'apc', 2, array($handles));
	var_dump($response[0]->status);
	var_dump($response[1]->status);

	sleep(2);

	// Second time pulls from cache
	$response = $sdb->cache_response(array($http, 'send_multi_request'), 'apc', 2, array($handles));
	var_dump($response[0]->status);
	var_dump($response[1]->status);
?>

--EXPECT--
int(200)
int(200)
int(200)
int(200)
