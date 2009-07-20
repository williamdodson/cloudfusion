--TEST--
AmazonSQS::cache_response MultiCurl CacheAPC

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();

	$handles = array();
	$handles[] = $sqs->list_queues(null, true);
	$handles[] = $sqs->list_queues(null, true);

	$http = new RequestCore(null);

	// First time pulls live data
	$response = $sqs->cache_response(array($http, 'send_multi_request'), 'apc', 2, array($handles));
	var_dump($response[0]->status);
	var_dump($response[1]->status);

	sleep(2);

	// Second time pulls from cache
	$response = $sqs->cache_response(array($http, 'send_multi_request'), 'apc', 2, array($handles));
	var_dump($response[0]->status);
	var_dump($response[1]->status);
?>

--EXPECT--
int(200)
int(200)
int(200)
int(200)
