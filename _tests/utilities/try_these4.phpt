--TEST--
CFUtilities - try_these with base

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Test data
	$obj = new StdClass;
	$obj->a = null;
	$obj->b = null;
	$obj->c = 1;
	$obj->d = null;

	// Instantiate
	$util = new CFUtilities();

	// Success?
	var_dump($util->try_these(array('a', 'b', 'c', 'd'), $obj, true));
?>

--EXPECT--
int(1)
