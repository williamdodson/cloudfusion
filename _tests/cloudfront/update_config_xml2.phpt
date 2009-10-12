--TEST--
CloudFront: update_config_xml() testing enabled, comments, and multiple CNAMEs

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	$cdn = new AmazonCloudFront();

	// Sample XML content
	$config_xml = $cdn->get_distribution_config('E2L6A3OZHQT5W4')->body;

	// Update the XML content
	$response = $cdn->update_config_xml($config_xml, array(
		'Enabled' => true,
		'Comment' => 'This is my sample comment',
		'CNAME' => array(
			'cdn1.warpshare.com',
			'cdn2.warpshare.com',
			'cdn3.warpshare.com'
		)
	));

	// Success?
	var_dump($response);
?>

--EXPECTF--
string(%d) "%s"
