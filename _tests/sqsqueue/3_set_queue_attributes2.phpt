--TEST--
AmazonSQSQueue::set_queue_attributes, changing visibility timeout, returning cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Change visibility timeout, returning cURL handle
	$sqs = new AmazonSQSQueue('warpshare-unit-test');
	$response = $sqs->set_queue_attributes(array(
		'VisibilityTimeout' => 7200,
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(10) of type (curl)
