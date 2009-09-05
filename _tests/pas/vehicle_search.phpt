--TEST--
AmazonPAS::vehicle_search - get all makes by year

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Set a locale and trigger an operation
	$pas = new AmazonPAS();
	$response = $pas->vehicle_search(array(
		'Year' => 2005,
		'ResponseGroup' => 'VehicleMakes'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
