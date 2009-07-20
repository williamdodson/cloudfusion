--TEST--
AmazonSQS::list_queues curl handle

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sqs = new AmazonSQS();
	$response = $sqs->list_queues('a', true);
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
