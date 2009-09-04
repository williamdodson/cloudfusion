--TEST--
AmazonPAS::list_lookup with returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for a list
	$pas = new AmazonPAS();
	$response = $pas->list_lookup('KAFYR57E8R81', 'WishList', array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
