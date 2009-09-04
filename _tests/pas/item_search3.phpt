--TEST--
AmazonPAS::item_search with ResponseGroup and returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for an item
	$pas = new AmazonPAS();
	$response = $pas->item_search('skillet awake', array(
		'ResponseGroup' => 'Large',
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
