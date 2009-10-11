--TEST--
AmazonSDB::delete_cache_response CachePDO:SQLite

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Delete the data
	$response = $sdb->delete_cache_response('list_domains', 'pdo.sqlite:' . dirname(dirname(__FILE__)) . '/_cache/sqlite.db');
	var_dump($response);
?>

--EXPECT--
bool(true)
