--TEST--
CFUtilities - json_encode_php51 integer

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->json_encode_php51(1));
?>

--EXPECT--
string(1) "1"