--TEST--
AmazonPAS::transaction_lookup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for similar items
	$pas = new AmazonPAS();
	$response = $pas->transaction_lookup('102-6791651-3962628');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
