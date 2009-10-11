--TEST--
AmazonSDB::cache_response MultiCurl CacheFile

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Prepare parallel requests
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
	$response = $sdb->cache_response(array($http, 'send_multi_request'), dirname(dirname(__FILE__)) . '/_cache', 2, array($handles));
	var_dump($response[0]->isOK());
	var_dump($response[1]->isOK());

	sleep(2);

	// Second time pulls from cache
	$response = $sdb->cache_response(array($http, 'send_multi_request'), dirname(dirname(__FILE__)) . '/_cache', 2, array($handles));
	var_dump($response[0]->isOK());
	var_dump($response[1]->isOK());
?>

--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
