--TEST--
Get a list of all possible options for this operation.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get a list of available options
	$pas = new AmazonPAS();
	$response = $pas->help('CustomerContentSearch', 'Operation');

	// View list
	print_r($response);
?>

--EXPECT--
All possible options for this operation.
