--TEST--
AmazonPAS::cart_modify - intentional error

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
		'%2BcgeaxKWE74bnHvaPPwZKdTcqwPB%2BsxyOgd2umMnTvT1A0Px1JRwyPijPD3CvBmsohKLo9IArgjZc1QkjL34z3Yj5axtYiyf',
		array(
			'Validate' => 'true'
		)
	);

	// Success?
	var_dump($response->isOK());
?>

--EXPECTF--
Fatal error: Uncaught exception 'PAS_Exception' with message '$cart_item_id MUST be an array. See the CloudFusion documentation for more details.' in %s:%d
Stack trace:
#0 %s(%d): AmazonPAS->cart_modify('valid-cart-id', 'valid-hmac', '%2BcgeaxKWE74bn...', Array)
#1 {main}
  thrown in %s on line %d
