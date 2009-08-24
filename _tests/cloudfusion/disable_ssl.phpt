--TEST--
CloudFusion - disable_ssl

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
	$f->disable_ssl(true);

	// Test if the value was set
	var_dump($f->enable_ssl);
?>

--EXPECT--
bool(false)
