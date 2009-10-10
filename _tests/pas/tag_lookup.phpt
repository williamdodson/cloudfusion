--TEST--
AmazonPAS::tag_lookup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for similar items
	$pas = new AmazonPAS();
	$response = $pas->tag_lookup('skillet');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
