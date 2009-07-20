--TEST--
AmazonSQS::set_queue_attributes curl handle

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->set_queue_attributes(SQS_DEFAULT_URL . '/warpshare-unit-test', array(
		'VisibilityTimeout' => 7200,
		'returnCurlHandle' => true
	));
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
