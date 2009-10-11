--TEST--
AmazonPAS::tag_lookup, with returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for tagged items
	$pas = new AmazonPAS();
	$response = $pas->tag_lookup('skillet', array(
		'ResponseGroup' => 'Large',
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
