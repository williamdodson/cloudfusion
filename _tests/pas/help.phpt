--TEST--
AmazonPAS::help

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Get help info
	$pas = new AmazonPAS();
	$response = $pas->help('CustomerContentSearch', 'Operation');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
