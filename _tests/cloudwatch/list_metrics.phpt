--TEST--
AmazonCloudWatch::list_metrics

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// List metrics
	$cw = new AmazonCloudWatch();
	$response = $cw->list_metrics();

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
