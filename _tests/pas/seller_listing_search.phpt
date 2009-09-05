--TEST--
AmazonPAS::seller_listing_search

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for an item
	$pas = new AmazonPAS();
	$response = $pas->seller_listing_search('ATVPDKIKX0DER');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
