--TEST--
CloudFusion - set_hostname

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	/**
	 * You wouldn't normally call this class directly. These methods
	 * are inherited by the service-specific classes.
	 */

	// Adjust offset
	$f = new CloudFusion();
	$f->set_hostname('example.com');

	// Test if the value was set
	var_dump($f->hostname);
?>

--EXPECT--
string(11) "example.com"
