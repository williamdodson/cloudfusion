--TEST--
CloudFront: disable_ssl()

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Update the XML content
	$cdn = new AmazonCloudFront();

	try
	{
		$cdn->disable_ssl();
	}
	catch (Exception $e)
	{
		echo $e->getMessage();
	}
?>

--EXPECT--
SSL/HTTPS is REQUIRED for CloudFront and cannot be disabled.
