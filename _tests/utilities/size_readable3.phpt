--TEST--
CFUtilities - size_readable retstring

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->size_readable(9876543210, 'kB', '%01.5f %s'));
?>

--EXPECT--
string(16) "9645061.72852 kB"
