--TEST--
AmazonPAS::customer_content_lookup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Look up the user
	$pas = new AmazonPAS();
	$response = $pas->customer_content_lookup('A1ESH8CKZLUV25');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
