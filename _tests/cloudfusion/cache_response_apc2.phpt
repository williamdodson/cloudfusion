--TEST--
AmazonSDB::cache_response CacheAPC

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->cache_response('list_domains', 'apc', 2);
	var_dump($response->isOK());

	sleep(2);

	// Second time pulls from cache
	$response = $sdb->cache_response('list_domains', 'apc', 2);
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
bool(true)
