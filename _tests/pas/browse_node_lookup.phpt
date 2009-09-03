--TEST--
AmazonPAS::browse_node_lookup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Browse a node
	$pas = new AmazonPAS();
	$response = $pas->browse_node_lookup('173429');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
