--TEST--
AmazonSDB::cache_response CacheFile

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->cache_response('list_domains', dirname(dirname(__FILE__)) . '/_cache', 2);
	var_dump($response->status);

	sleep(2);

	// Second time pulls from cache
	$response = $sdb->cache_response('list_domains', dirname(dirname(__FILE__)) . '/_cache', 2);
	var_dump($response->status);
?>

--EXPECT--
int(200)
int(200)

--CLEAN--
<?php

?>