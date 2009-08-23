--TEST--
AmazonSQS::cache_response CacheMC

--SKIPIF--
<?php
	if (!method_exists('Memcache', 'connect')) print 'skip Memcached extension not available';
	elseif (!Memcache::connect('127.0.0.1')) print 'skip Memcached cannot connect to server';
?>

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();

	// First time pulls live data
	$response = $sqs->cache_response('list_queues', array(
		array('host' => '127.0.0.1')
	), 10);
	var_dump($response->isOK());

	// Second time pulls from cache
	$response = $sqs->cache_response('list_queues', array(
		array('host' => '127.0.0.1')
	), 10);
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
bool(true)
