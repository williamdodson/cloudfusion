--TEST--
AmazonSDB::delete_cache_response CacheMC

--SKIPIF--
<?php
	if (!method_exists('Memcache', 'connect')) print 'skip Memcached extension not available';
	elseif (!Memcache::connect('127.0.0.1')) print 'skip Memcached cannot connect to server';
?>

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Delete the data
	$response = $sdb->delete_cache_response('list_domains', array(
		array('host' => '127.0.0.1')
	));
	var_dump($response);
?>

--EXPECT--
bool(true)
