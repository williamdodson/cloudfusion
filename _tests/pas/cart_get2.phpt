--TEST--
AmazonPAS::cart_get - returnCurlHandle.

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Validate whether a request would be successful, without executing it, using the 'Validate' option.
	// Replace 'valid-cart-id' and 'valid-hmac' with real values from the <create_cart()> response.
	$pas = new AmazonPAS();
	$response = $pas->cart_get('valid-cart-id', 'valid-hmac', array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
