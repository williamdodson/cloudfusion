--TEST--
CFUtilities - try_these with default value

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Success?
	var_dump($util->try_these(array(null, null, null, null), null, true));
?>

--EXPECT--
bool(true)
