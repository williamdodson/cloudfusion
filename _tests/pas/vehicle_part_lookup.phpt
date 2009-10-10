--TEST--
AmazonPAS::vehicle_part_lookup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Use vehicle_search() to look up these values
	$pas = new AmazonPAS();
	$response = $pas->vehicle_part_lookup(59, 752, 2005, 'B000IYDEPG');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
