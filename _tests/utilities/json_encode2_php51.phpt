--TEST--
CFUtilities - json_encode_php51 boolean

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->json_encode_php51(true));
?>

--EXPECT--
string(4) "true"
