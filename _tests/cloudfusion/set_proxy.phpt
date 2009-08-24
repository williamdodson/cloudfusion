--TEST--
CloudFusion - set_proxy

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
	$f->set_proxy('test');

	// Test if the value was set
	var_dump($f->set_proxy);
?>

--EXPECT--
string(4) "test"