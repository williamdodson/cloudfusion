--TEST--
AmazonPAS::vehicle_part_search

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Set a locale and trigger an operation
	$pas = new AmazonPAS();

	// Use vehicle_search() to look up these values
	$response = $pas->vehicle_part_search(
		59, // Honda
		752, // Civic
		2005
	);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
