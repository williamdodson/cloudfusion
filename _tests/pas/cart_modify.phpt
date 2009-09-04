--TEST--
AmazonPAS::cart_modify - single item, validate only.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Validate whether a request would be successful, without executing it, using the 'Validate' option.
	// Replace 'valid-cart-id' and 'valid-hmac' with real values from the <create_cart()> response.
	// Added line breaks for readability.
	$pas = new AmazonPAS();
	$response = $pas->cart_modify(
		'valid-cart-id',
		'valid-hmac',
		array(
			'%2BcgeaxKWE74bnHvaPPwZKdTcqwPB%2BsxyOgd2umMnTvT1A0Px1JRwyPijPD3CvBmsohKLo9IArgjZc1QkjL34z3Yj5axtYiyf' => 5
		),
		array(
			'Validate' => 'true'
		)
	);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
