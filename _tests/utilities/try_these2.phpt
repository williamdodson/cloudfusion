--TEST--
CFUtilities - try_these values2

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Success?
	var_dump($util->try_these(array(null, null, 1, null)));
?>

--EXPECT--
int(1)
