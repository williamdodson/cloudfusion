--TEST--
AmazonPAS::list_search, skipping $email_name and explicitly setting FirstName and LastName.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for a list
	$pas = new AmazonPAS();
	$response = $pas->list_search(null, 'WishList', array(
		'FirstName' => 'Ryan',
		'LastName' => 'Parman'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
