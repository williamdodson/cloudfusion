--TEST--
AmazonPAS::cart_add - multiple items, multiple quantities, returnCurlHandle.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Validate whether a request would be successful, without executing it, using the 'Validate' option.
	// Replace 'valid-cart-id' and 'valid-hmac' with real values from the <create_cart()> response.
	// Added line breaks for readability.
	$pas = new AmazonPAS();
	$response = $pas->cart_add(
		'valid-cart-id',
		'valid-hmac',
		array(
			'%2BcgeaxKWE74bnHvaPPwZKdTcqwPB%2BsxyOgd2umMnTvT1A0Px1JRwyPijPD3CvBmsohKLo9IArgjZc1QkjL34z3Yj5axtYiyf' => 15,
			'L8gljSEq%2FXqKabPO8rZWrJnKBc1ZOAC5iNhpyITjDo%2FHxJ%2Bqt2oZ01Cx0I%2BgIQziGxUHqhfn0K2wsJziNp4jrA%3D%3D' => 5
		),
		array(
			'returnCurlHandle' => true
		)
	);

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
