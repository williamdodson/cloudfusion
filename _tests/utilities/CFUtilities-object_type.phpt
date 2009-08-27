--TEST--
CFUtilities - Object type

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump(get_class($util));
?>

--EXPECT--
string(11) "CFUtilities"
