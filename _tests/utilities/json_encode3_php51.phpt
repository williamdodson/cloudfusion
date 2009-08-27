--TEST--
CFUtilities - json_encode_php51 string

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->json_encode_php51('example'));
?>

--EXPECT--
string(9) ""example""
