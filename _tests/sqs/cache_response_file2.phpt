--TEST--
AmazonSQS::cache_response CacheFile

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();

	// First time pulls live data
	$response = $sqs->cache_response('list_queues', './cache', 2);
	var_dump($response->status);

	sleep(2);

	// Second time pulls from cache
	$response = $sqs->cache_response('list_queues', './cache', 2);
	var_dump($response->status);
?>

--EXPECT--
int(200)
int(200)

--CLEAN--
<?php
	
?>