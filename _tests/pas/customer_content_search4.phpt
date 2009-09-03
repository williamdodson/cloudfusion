--TEST--
AmazonPAS::customer_content_search with ResponseGroup and returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Look up the user
	$pas = new AmazonPAS();
	$response = $pas->customer_content_search('Ryan Parman', array(
		'ResponseGroup' => 'CustomerInfo',
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
