--TEST--
CFUtilities - try_these with base & default

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	$obj = new StdClass;
	$obj->a = null;
	$obj->b = null;
	$obj->c = null;
	$obj->d = null;

	$util = new CFUtilities();
	var_dump($util->try_these(array('a', 'b', 'c', 'd'), $obj, true));
?>

--EXPECT--
bool(true)
