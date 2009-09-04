--TEST--
AmazonPAS::list_search by email address

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for a list
	$pas = new AmazonPAS();
	$response = $pas->list_search('ryan@getcloudfusion.com', 'WishList');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
