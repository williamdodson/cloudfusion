--TEST--
AmazonSDB::delete_cache_response CacheFile

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Delete the data
	$response = $sdb->delete_cache_response('list_domains', dirname(dirname(__FILE__)) . '/_cache');
	var_dump($response);
?>

--EXPECT--
bool(true)
