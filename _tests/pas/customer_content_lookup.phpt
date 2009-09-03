--TEST--
AmazonPAS::customer_content_lookup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Browse a node
	$pas = new AmazonPAS();
	$response = $pas->customer_content_lookup('A1ESH8CKZLUV25');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
