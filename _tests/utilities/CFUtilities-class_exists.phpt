--TEST--
CFUtilities - Exists

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$s3 = new CFUtilities();

	// Test data
	var_dump(class_exists('CFUtilities'));
?>

--EXPECT--
bool(true)
