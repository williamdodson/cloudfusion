--TEST--
CFUtilities - size_readable other units

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->size_readable(9876543210, 'kB'));
?>

--EXPECT--
string(13) "9645061.73 kB"
