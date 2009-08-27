--TEST--
CFUtilities - Get parent class

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$s3 = new CFUtilities();

	// Test data
	var_dump(get_parent_class('CFUtilities'));
?>

--EXPECT--
bool(false)