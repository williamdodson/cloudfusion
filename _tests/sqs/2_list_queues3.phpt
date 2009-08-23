--TEST--
AmazonSQS::list_queues, with prefix, returning cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List queues, with prefix 'a', returning the cURL handle
	$sqs = new AmazonSQS();
	$response = $sqs->list_queues('a', true);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
