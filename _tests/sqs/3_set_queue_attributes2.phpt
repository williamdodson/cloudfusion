--TEST--
AmazonSQS::set_queue_attributes, changing visibility timeout, returning cURL handle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Change visibility timeout, returning cURL handle
	$sqs = new AmazonSQS();
	$response = $sqs->set_queue_attributes(SQS_DEFAULT_URL . '/warpshare-unit-test', array(
		'VisibilityTimeout' => 7200,
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
