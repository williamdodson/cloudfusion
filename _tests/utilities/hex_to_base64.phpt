--TEST--
CFUtilities - hex_to_base64

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->hex_to_base64('example'));
?>

--EXPECT--
string(8) "DgoADg=="
