--TEST--
AmazonSDB::cache_response CachePDO:SQLite

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->cache_response('list_domains', 'pdo.sqlite:' . dirname(dirname(__FILE__)) . '/_cache/sqlite.db', 10);
	var_dump($response->status);

	// Second time pulls from cache
	$response = $sdb->cache_response('list_domains', 'pdo.sqlite:' . dirname(dirname(__FILE__)) . '/_cache/sqlite.db', 10);
	var_dump($response->status);
?>

--EXPECT--
int(200)
int(200)
