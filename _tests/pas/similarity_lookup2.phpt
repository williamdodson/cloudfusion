--TEST--
AmazonPAS::similarity_lookup, with returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Use vehicle_search() to look up these values
	$pas = new AmazonPAS();
	$response = $pas->similarity_lookup('B002FZL94O', array(
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
