--TEST--
AmazonPAS::cart_create - single item, multiple quantities, returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Validate whether a request would be successful, without executing it, using the 'Validate' option.
	$pas = new AmazonPAS();
	$response = $pas->cart_create(array(
		'%2BcgeaxKWE74bnHvaPPwZKdTcqwPB%2BsxyOgd2umMnTvT1A0Px1JRwyPijPD3CvBmsohKLo9IArgjZc1QkjL34z3Yj5axtYiyf' => 15
	), array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
