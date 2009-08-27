--TEST--
CFUtilities - try_these values

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Test data
	$util = new CFUtilities();

	// Success?
	var_dump($util->try_these(array(1, null, null, null)));
?>

--EXPECT--
int(1)
