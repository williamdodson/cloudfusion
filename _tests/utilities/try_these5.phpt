--TEST--
CFUtilities - try_these with base & default

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Test data
	$obj = new StdClass;
	$obj->a = null;
	$obj->b = null;
	$obj->c = null;
	$obj->d = null;

	// Instantiate
	$util = new CFUtilities();

	// Success?
	var_dump($util->try_these(array('a', 'b', 'c', 'd'), $obj, true));
?>

--EXPECT--
bool(true)
