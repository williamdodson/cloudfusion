--TEST--
AmazonCloudWatch::get_metric_statistics + Optional parameters

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get metrics
	$cw = new AmazonCloudWatch();
	$response = $cw->get_metric_statistics('CPUUtilization', 'Average', 'Percent', '1 August 2009', '31 August 2009', array(
		'Namespace' => 'AWS/EC2',
		'Period' => 1800
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
