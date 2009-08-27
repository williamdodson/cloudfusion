--TEST--
AmazonCloudWatch::list_metrics + NextToken

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List metrics
	$cw = new AmazonCloudWatch();
	$response = $cw->list_metrics(array(
		'NextToken' => 't' // Invalid
	));

	// Success?
	var_dump($response->body->Error->Message);
?>

--EXPECT--
object(SimpleXMLElement)#7 (1) {
  [0]=>
  string(17) "Invalid nextToken"
}
