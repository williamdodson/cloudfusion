--TEST--
AmazonPAS::transaction_lookup, with returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Lookup a given transaction ID.
	$pas = new AmazonPAS();
	$response = $pas->transaction_lookup('102-6791651-3962628', array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
