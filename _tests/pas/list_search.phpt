--TEST--
AmazonPAS::list_search by name

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for a list
	$pas = new AmazonPAS();
	$response = $pas->list_search('Ryan Parman', 'WishList');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
