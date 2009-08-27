--TEST--
CFUtilities - size_readable

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->size_readable(9876543210));
?>

--EXPECT--
string(7) "9.20 GB"
