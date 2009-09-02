--TEST--
AmazonSQSQueue::cache_response CacheAPC

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQSQueue();

	// First time pulls live data
	$response = $sqs->cache_response('list_queues', 'apc', 10);
	var_dump($response->isOK());

	// Second time pulls from cache
	$response = $sqs->cache_response('list_queues', 'apc', 10);
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
bool(true)
