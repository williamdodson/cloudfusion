--TEST--
AmazonSDB::cache_response CacheMC

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
	$s3 = new AmazonS3();

	// First time pulls live data
	$response = $s3->cache_response('get_object_url', array(
		array('host' => '127.0.0.1')
	), 10, array('tarzan.demo', 'macgyver_gets_lazy.png', 3600));
	var_dump($response);

	// Second time pulls from cache
	$response = $s3->cache_response('get_object_url', array(
		array('host' => '127.0.0.1')
	), 10, array('tarzan.demo', 'macgyver_gets_lazy.png', 3600));
	var_dump($response);
?>

--EXPECTF--
string(%d) "http://tarzan.demo.s3.amazonaws.com/macgyver_gets_lazy.png?%s"
string(%d) "http://tarzan.demo.s3.amazonaws.com/macgyver_gets_lazy.png?%s"
