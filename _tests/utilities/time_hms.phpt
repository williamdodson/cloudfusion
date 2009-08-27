--TEST--
CFUtilities - time_hms

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->time_hms(98765));
?>

--EXPECT--
string(8) "27:26:05"
