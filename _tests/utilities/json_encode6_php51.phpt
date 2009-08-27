--TEST--
CFUtilities - json_encode_php51 list

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->json_encode_php51(array(
		'string',
		1,
		1.2,
		true,
	)));
?>

--EXPECT--
string(21) "["string",1,1.2,true]"
