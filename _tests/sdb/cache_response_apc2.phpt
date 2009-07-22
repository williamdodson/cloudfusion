--TEST--
AmazonSDB::cache_response CacheAPC

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->cache_response('list_domains', 'apc', 2);
	var_dump($response->status);

	sleep(2);

	// Second time pulls from cache
	$response = $sdb->cache_response('list_domains', 'apc', 2);
	var_dump($response->status);
?>

--EXPECT--
int(200)
int(200)
