--TEST--
AmazonPAS::transaction_lookup, with returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Use vehicle_search() to look up these values
	$pas = new AmazonPAS();
	$response = $pas->transaction_lookup('102-6791651-3962628', array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
