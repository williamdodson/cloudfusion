--TEST--
CFUtilities - convert_date_to_iso8601

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate the object
	$util = new CFUtilities();

	// Test for ISO-8601, and convert if not.
	$date_correct = '2009-08-01T07:00:00Z';
	$date_incorrect = '1 August 2009, 7am GMT';

	// Success?
	var_dump($util->convert_date_to_iso8601($date_correct));
	var_dump($util->convert_date_to_iso8601($date_incorrect));
?>

--EXPECT--
string(20) "2009-08-01T07:00:00Z"
string(20) "2009-08-01T07:00:00Z"
