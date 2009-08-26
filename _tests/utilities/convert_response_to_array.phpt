--TEST--
CFUtilities - convert_response_to_array

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get a ResponseCore response
	$pas = new AmazonPAS();
	$data = $pas->item_search('skillet awake');

	// Convert SimpleXMLElement to Array.
	$data = $pas->util->convert_response_to_array($data);

	// Success?
	var_dump($data['body']['Items']['Request']['ItemSearchRequest']['Keywords']);
?>

--EXPECT--
string(13) "skillet awake"
