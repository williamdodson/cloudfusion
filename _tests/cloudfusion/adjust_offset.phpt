--TEST--
CloudFusion - adjust_offset

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	/**
	 * You wouldn't normally call this class directly. These methods
	 * are inherited by the service-specific classes.
	 */

	// Adjust offset
	$cf = new CloudFusion();
	$cf->adjust_offset(123456789);

	// Test if the value was set
	var_dump($cf->adjust_offset);
?>

--EXPECT--
int(123456789)
