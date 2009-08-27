--TEST--
CFUtilities - json_encode list

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->json_encode(array(
		'string',
		1,
		1.2,
		true,
	)));
?>

--EXPECT--
string(21) "["string",1,1.2,true]"
