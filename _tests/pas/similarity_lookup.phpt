--TEST--
AmazonPAS::similarity_lookup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for similar items
	$pas = new AmazonPAS();
	$response = $pas->similarity_lookup('B002FZL94O');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
